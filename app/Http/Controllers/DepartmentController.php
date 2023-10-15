<?php

namespace App\Http\Controllers;

use App\Models\Admin\SchoolSettings;
use App\Models\Admin\SchoolYear;
use App\Models\Syllabi\SyllabiBP\SubjectBP;
use App\Models\SyllabiArchive\SubjectArchive;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Syllabi\Subject;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:department.show')->only('show');
        $this->middleware('can:department.store')->only('store');
        $this->middleware('can:department.update')->only('update');
        $this->middleware('can:department.destroy')->only('destroy');
        $this->middleware('can:department.activate')->only('activate');

        $this->middleware('can:department.subject.store')->only('store_subject');
        $this->middleware('can:department.subject.destroy')->only('destroy_subject');
    }

    public function show(Request $request)
    {
        $departments = Department::all();
        $teachersData = Role::where('name', 'teacher')->first()->users;
        
        $teachers = $teachersData->map(function ($user) {
            return $user->only(['id', 'name', 'surname', 'email']);
        });

        // Obtain the day of today
        $today = Carbon::now();

        // Obtain the settings
        $settings = SchoolSettings::first();
        $current_year = SchoolYear::getSchoolYear();

        // We will be working with the already archived subjects for the current year
        if (($settings->current_enrollment && $today->gte(Carbon::parse($settings->current_enrollment))) || count($current_year->syllabis) > 0) {
            $subjects = $current_year->subjects;

            $departmentsWithAdditionalData = $departments->map(function ($department) {
                return [
                    'id' => $department->id,
                    'name' => $department->name,
                    'users' => 'TO-DO',
                    'subjects' => $department->current_subjects->map(function ($s) {
                        return [
                            'id' => $s->id,
                            'name' => $s->name,
                            'is_active' => $s->is_active,
                        ];
                    })->toArray(),
                    'in_charge' => $department->inCharge,
                    'color' => $department->color,
                    'meeting_day' => $department->meeting_day,
                    'meeting_time' => $department->meeting_time,
                    'is_active' => $department->is_active,
                ];
            });

        } else {
            $subjects = SubjectBP::where('is_active', true)->get();

            $departmentsWithAdditionalData = $departments->map(function ($department) {
                return [
                    'id' => $department->id,
                    'name' => $department->name,
                    'users' => 'TO-DO',
                    'subjects' => $department->active_subjects_bp->map(function ($s) {
                        return [
                            'id' => $s->id,
                            'name' => $s->name,
                            'is_active' => $s->is_active,
                        ];
                    })->toArray(),
                    'in_charge' => $department->inCharge,
                    'color' => $department->color,
                    'meeting_day' => $department->meeting_day,
                    'meeting_time' => $department->meeting_time,
                    'is_active' => $department->is_active,
                ];
            });
        }

        return Inertia::render('Department/Show', [
            'departments' => $departmentsWithAdditionalData,
            'subjects' => $subjects,
            'teachers' => $teachers,
            'customroute' => "department.show",
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:departments,name'],
            'user_id' => ['required', 'exists:users,id'],
            'color' => ['required', 'regex:/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/'],
            'meeting_day' => ['required', 'in:1,2,3,4,5,6,7'],
            'meeting_time' => ['required', 'date_format:H:i'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        try {
            Department::create([
                'name' => $request->input('name'),
                'in_charge' => $request->input('user_id'),
                'color' => $request->input('color'),
                'meeting_day' => $request->input('meeting_day'),
                'meeting_time' => $request->input('meeting_time'),
            ]);

            return redirect()->back()->with('success', '¡Departamento creado correctamente!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error al crear el departamento.');
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:departments,id'],
            'name' => ['required', 'unique:departments,name,' . $request->input('id')],
            'user_id' => ['required', 'exists:users,id'],
            'color' => ['required', 'regex:/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/'],
            'meeting_day' => ['required', 'in:1,2,3,4,5,6,7'],
            'meeting_time' => ['required', 'date_format:H:i'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        try {
            $department = Department::find($request->input('id'));
            $department->name = $request->input('name');
            $department->in_charge = $request->input('user_id');
            $department->color = $request->input('color');
            $department->meeting_day = $request->input('meeting_day');
            $department->meeting_time = $request->input('meeting_time');
            $department->save();

            return redirect()->back()->with('success', '¡Departamento actualizado correctamente!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error al actualizar el departamento.');
        }
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:departments,id'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        // We can only delete a department if it has no subjects assigned
        $department = Department::find($request->input('id'));
        if($department->subjects()->count() > 0) {
            return redirect()->back()->withErrors('No se puede desactivar el departamento porque tiene asignaturas asignadas.');
        }

        try {
            // Remove the head of the department and deactivate it
            $department->is_active = false;
            $department->in_charge = null;
            $department->save();


            return redirect()->back()->with('success', '¡Departamento eliminado correctamente!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error al eliminar el departamento.');
        }
    }

    public function activate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:departments,id'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        try {
            Department::find($request->input('id'))->update([
                'in_charge' => $request->input('user_id'),
                'is_active' => true,
            ]);

            return redirect()->back()->with('success', '¡Departamento activado correctamente!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error al activar el departamento.');
        }
    }

    public function store_subject(Request $request)
    {
        // Obtain the day of today
        $today = Carbon::now();

        // Obtain the settings
        $settings = SchoolSettings::first();
        $current_year = SchoolYear::getSchoolYear();

        $is_archived = false;
        $is_next_archived = false;

        // We will be working with the already archived subjects for the current year
        if (($settings->current_enrollment && $today->gte(Carbon::parse($settings->current_enrollment))) || count($current_year->syllabis) > 0) {
            $validator = Validator::make($request->all(), [
                'id' => ['required', 'exists:departments,id'],
                'subject_ids' => ['required', 'array'],
                'subject_ids.*' => ['required', 'exists:subjects,id'],
            ]);
            $is_archived = true;

            // If we have also surpassed the next enrollment, then we will also try to update the subjects
            $next_year = SchoolYear::getNextSchoolYear();
            if(($settings->next_enrollment && $today->gte(Carbon::parse($settings->next_enrollment))) || count($next_year->syllabis) > 0) {
                $is_next_archived = true;
            }

        } else {
            $validator = Validator::make($request->all(), [
                'id' => ['required', 'exists:departments,id'],
                'subject_ids' => ['required', 'array'],
                'subject_ids.*' => ['required', 'exists:subjects_blueprint,id'],
            ]);
        }

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        try {
            DB::beginTransaction();

            $department = Department::find($request->input('id'));

            foreach ($request->input('subject_ids') as $subjectId) {
                if($is_archived) {
                    $subject = Subject::find($subjectId);
                    $subjectActive = SubjectBP::where('name', $subject->name)->first();
                    if($subjectActive != null) {
                        $subjectActive->department()->associate($department);
                        $subjectActive->save();
                    }
                    if($is_next_archived) {
                        $subjectNextYear = Subject::where('name', $subject->name)->where('school_year_id', $next_year->id)->first();
                        if($subjectNextYear != null) {
                            $subjectNextYear->department()->associate($department);
                            $subjectNextYear->save();
                        }
                    }
                }
                else {
                    $subject = SubjectBP::find($subjectId);
                }
                $subject->department()->associate($department);
                $subject->save();
            }

            DB::commit();

            return redirect()->back()->with('success', '¡Asignaturas agregada/s correctamente!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Error al agregar las asignaturas.');
        }
    }

    public function destroy_subject(Request $request)
    {

        // Obtain the day of today
        $today = Carbon::now();

        // Obtain the settings
        $settings = SchoolSettings::first();
        $current_year = SchoolYear::getSchoolYear();

        $is_archived = false;
        $is_next_archived = false;

        // We will be working with the already archived subjects for the current year
        if (($settings->current_enrollment && $today->gte(Carbon::parse($settings->current_enrollment))) || count($current_year->syllabis) > 0) {
            $validator = Validator::make($request->all(), [
                'id' => ['required', 'exists:departments,id'],
                'subject_id' => ['required', 'exists:subjects,id'],
            ]);
            $is_archived = true;

            // If we have also surpassed the next enrollment, then we will also try to update the next year's subjects
            $next_year = SchoolYear::getNextSchoolYear();
            if(($settings->next_enrollment && $today->gte(Carbon::parse($settings->next_enrollment))) || count($next_year->syllabis) > 0) {
                $is_next_archived = true;
            }

        } else {
            $validator = Validator::make($request->all(), [
                'id' => ['required', 'exists:departments,id'],
                'subject_id' => ['required', 'exists:subjects_blueprint,id'],
            ]);
        }
        
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        try {
            DB::beginTransaction();

            if($is_archived) {
                $subject = Subject::find($request->input('subject_id'));
                $subjectActive = SubjectBP::where('name', $subject->name)->first();
                if($subjectActive != null) {
                    $subjectActive->department()->dissociate();
                    $subjectActive->save();
                }
                if($is_next_archived) {
                    $subjectNextYear = Subject::where('name', $subject->name)->where('school_year_id', $next_year->id)->first();
                    if($subjectNextYear != null) {
                        $subjectNextYear->department()->dissociate();
                        $subjectNextYear->save();
                    }
                }
            }
            else {
                $subject = SubjectBP::find($request->input('subject_id'));
            }
            $subject->department()->dissociate();
            $subject->save();

            DB::commit();

            return redirect()->back()->with('success', '¡Asignaturas eliminada correctamente!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Error al eliminar las asignaturas.');
        }
    }

}
