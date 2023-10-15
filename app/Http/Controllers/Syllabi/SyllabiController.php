<?php

namespace App\Http\Controllers\Syllabi;

use App\Http\Controllers\Controller;
use App\Models\Syllabi\SyllabiBP\CourseBP;
use App\Models\Syllabi\SyllabiBP\DegreeBP;
use App\Models\Syllabi\SyllabiBP\SpecialityBP;
use App\Models\Syllabi\SyllabiBP\SubjectBP;
use App\Models\Syllabi\SyllabiBP\SyllabiBP;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Admin\SchoolSettings;
use Illuminate\Support\Facades\DB;

class SyllabiController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:syllabi.store')->only(['create', 'store']);
        $this->middleware('can:syllabi.update')->only(['edit', 'update']);
        $this->middleware('can:syllabi.destroy')->only(['destroy']);
    }

    /**
     * Display the syllabi creation view.
     */
    public function create()
    {
        // Obtain the day of today using Carbon
        $today = Carbon::now();

        // Obtain the settings
        $settings = SchoolSettings::first();

        // If the current enrollment is in the past and the next one has already started, then we can't create a new syllabi
        if($today->gte(Carbon::parse($settings->current_enrollment)) 
        && ( $settings->next_enrollment && $today->gte(Carbon::parse($settings->next_enrollment)))) {
            return redirect()->route('syllabi.show');
        }

        // Get all the active degrees
        $degrees = DegreeBP::where('is_active', true)->get();

        // Get all the active courses
        $courses = CourseBP::where('is_active', true)->get();

        // Get all the active specialities
        $specialities = SpecialityBP::where('is_active', true)->get();

        // For each speciality, obtain their corresponding subjects
        $specialitiesWithAdditionalData = $specialities->map(function ($speciality) {
            return [
                'id' => $speciality->id,
                'name' => $speciality->name,
                'subjects' => $speciality->subjects->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'name' => $s->name,
                        'is_collective' => $s->is_collective,
                        'student_ratio' => $s->student_ratio,
                    ];
                })->toArray(),
                'is_active' => $speciality->is_active,
            ];
        });

        // Get all the active subjects and those which speciality_id is null
        $subjects = SubjectBP::where('is_active', true)->whereNull('speciality_id')->get();

        return Inertia::render('Syllabi/SyllabiCreate', [
            'customroute' => "syllabi.show",
            'degrees' => $degrees,
            'courses' => $courses,
            'specialities' => $specialitiesWithAdditionalData,
            'subjects' => $subjects,
        ]);
    }

    /**
     * Stores the syllabi in the database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'age' => 'required|numeric|min:0|max:99',
            'max_failed_subjects_to_pass' => 'required|numeric|min:0|max:99',
            'degree' => 'required|exists:degrees_blueprint,id',
            'course' => 'required|exists:courses_blueprint,id',
            
            'specialities_data' => 'nullable|array',
            'specialities_data.*.id' => 'required|exists:specialities_blueprint,id',
            'specialities_data.*.name' => 'required|string|max:255',
            'specialities_data.*.subjects' => 'required|array',
            'specialities_data.*.subjects.*.id' => 'required|exists:subjects_blueprint,id',
            'specialities_data.*.subjects.*.name' => 'required|string|max:255',
            'specialities_data.*.subjects.*.is_mandatory' => 'required|boolean',
            'specialities_data.*.subjects.*.school_hours' => 'nullable|numeric|min:0',
            'specialities_data.*.subjects.*.price' => 'nullable|numeric|min:0',
            'specialities_data.*.subjects.*.student_ratio' => 'nullable|numeric|min:0',
            'specialities_data.*.subjects.*.remove' => 'required|boolean',
        
            'subjects_data' => 'required|array',
            'subjects_data.*.name' => 'required|string|max:255',
            'subjects_data.*.id' => 'required|exists:subjects_blueprint,id',
            'subjects_data.*.is_mandatory' => 'required|boolean',
            'subjects_data.*.school_hours' => 'required|numeric|min:0',
            'subjects_data.*.price' => 'required|numeric|min:0',
            'subjects_data.*.student_ratio' => 'required|numeric|min:0',
        ]);

        // Check that the degree is active
        $inactiveDegree = DegreeBP::where('id', $validatedData['degree'])->where('is_active', false)->first();

        if ($inactiveDegree) {
            return redirect()->back()->withErrors([
                'degree' => 'Has seleccionado un grado que esta desactivado.'
            ]);
        }

        // Check that the course is active
        $inactiveCourse = CourseBP::where('id', $validatedData['course'])->where('is_active', false)->first();

        if ($inactiveCourse) {
            return redirect()->back()->withErrors([
                'course' => 'Has seleccionado un curso que esta desactivado.'
            ]);
        }

        // Check that the specialities are active
        $specialityIds = array_keys($validatedData['specialities_data']);
        $inactiveSpecialities = SpecialityBP::whereIn('id', $specialityIds)->where('is_active', false)->get();

        // Check that the subjects are active
        $inactiveSubjects = SubjectBP::whereIn('id', array_keys($validatedData['subjects_data']))->where('is_active', false)->get();

        if ($inactiveSpecialities->count() || $inactiveSubjects->count()) {
            return redirect()->back()->withErrors([
                'subjects' => 'Has seleccionado asignaturas/especialidades que estan desactivadas.'
            ]);
        }

        try {
            DB::beginTransaction();

            // Create the syllabi
            $syllabi = SyllabiBP::create([
                'name' => $validatedData['name'],
                'age' => $validatedData['age'],
                'max_failed_subjects_to_pass' => $validatedData['max_failed_subjects_to_pass'],
                'course_id' => $validatedData['course'],
                'degree_id' => $validatedData['degree'],
            ]);

            // Attach the specialities to the syllabi
            $syllabi->specialities()->attach($specialityIds);

            // Create the subjects
            foreach ($validatedData['subjects_data'] as $subjectData) {
                $syllabi->subjects()->attach($subjectData['id'], [
                    'is_mandatory' => $subjectData['is_mandatory'],
                    'school_hours' => $subjectData['school_hours'],
                    'price' => $subjectData['price'],
                    'student_ratio' => $subjectData['student_ratio'],
                ]);
            }

            // Add speciality subjects to the syllabi (only if remove is false)
            foreach ($validatedData['specialities_data'] as $specialityData) {
                foreach ($specialityData['subjects'] as $subjectData) {
                    if (!$subjectData['remove']) { // Only add if remove is false
                        $syllabi->subjects()->attach($subjectData['id'], [
                            'is_mandatory' => $subjectData['is_mandatory'],
                            'school_hours' => $subjectData['school_hours'],
                            'price' => isset($subjectData['price']) ? $subjectData['price'] : null,
                            'is_speciality' => true,
                            'student_ratio' => isset($subjectData['student_ratio']) ? $subjectData['student_ratio'] : null,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('syllabi.show');
        }
        catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Error al crear el plan de estudios.' . $e->getMessage());
        }
    }

    /**
     * Edit the elements that can be used to make a syllabi
     */
    public function edit(SyllabiBP $syllabi)
    {
        // Get all the active degrees
        $degrees = DegreeBP::where('is_active', true)->get();

        // Get all the active courses
        $courses = CourseBP::where('is_active', true)->get();

        // Get all the active specialities
        $specialities = SpecialityBP::where('is_active', true)->get();

        // For each speciality, obtain their corresponding subjects
        $specialitiesWithAdditionalData = $specialities->map(function ($speciality) {
            return [
                'id' => $speciality->id,
                'name' => $speciality->name,
                'subjects' => $speciality->subjects->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'name' => $s->name,
                        'is_collective' => $s->is_collective,
                        'student_ratio' => $s->student_ratio,
                    ];
                })->toArray(),
                'is_active' => $speciality->is_active,
            ];
        });

        // Get all the active subjects
        $subjects = SubjectBP::where('is_active', true)->whereNull('speciality_id')->get();

        // Get all the info of the syllabi
        $syllabiWithAdditionalData = [
                'id' => $syllabi->id,
                'name' => $syllabi->name,
                'course' => [
                        'id' => $syllabi->course->id,
                        'number' => $syllabi->course->number,
                        'name' => $syllabi->course->name,
                ],
                'degree' => [
                        'id' => $syllabi->degree->id,
                        'name' => $syllabi->degree->name,
                ],
                'specialities' => $syllabi->specialities->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'name' => $s->name,
                    ];
                })->toArray(),
                'subjects' => $syllabi->subjects->filter(function ($s) {
                    return $s->pivot->is_speciality == false;
                })->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'name' => $s->name,
                        'is_mandatory' => $s->pivot->is_mandatory,
                        'school_hours' => $s->pivot->school_hours,
                        'price' => $s->pivot->price,
                        'student_ratio' => $s->pivot->student_ratio,
                    ];
                })->toArray(),
                'speciality_subjects' => $syllabi->subjects->filter(function ($s) {
                    return $s->pivot->is_speciality == true;
                })->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'name' => $s->name,
                        'is_collective' => $s->is_collective,
                        'is_mandatory' => $s->pivot->is_mandatory,
                        'school_hours' => $s->pivot->school_hours,
                        'price' => $s->pivot->price,
                        'student_ratio' => $s->pivot->student_ratio,
                    ];
                })->toArray(),
                'age' => $syllabi->age,
                'max_failed_subjects_to_pass' => $syllabi->max_failed_subjects_to_pass,
                'is_active' => $syllabi->is_active,
        ];

        return Inertia::render('Syllabi/SyllabiEdit', [
            'customroute' => "syllabi.show",
            'degrees' => $degrees,
            'courses' => $courses,
            'specialities' => $specialitiesWithAdditionalData,
            'subjects' => $subjects,
            'syllabi' => $syllabiWithAdditionalData,
        ]);
    }

    /**
     * Update the elements that can be used to make a syllabi
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:syllabis_blueprint,id',
            'name' => 'nullable|string|max:255',
            'age' => 'required|numeric|min:0|max:99',
            'max_failed_subjects_to_pass' => 'required|numeric|min:0|max:99',
            'degree' => 'required|exists:degrees_blueprint,id',
            'course' => 'required|exists:courses_blueprint,id',
        
            // Validación para especialidades (si te refieres a ellas directamente)
            'specialities' => 'sometimes|array',
            'specialities.*' => 'exists:specialities_blueprint,id',
        
            // Validación para specialities_subjects_data
            'specialities_subjects_data' => 'required|array',
            'specialities_subjects_data.*.*.id' => 'required|exists:subjects_blueprint,id',
            'specialities_subjects_data.*.*.name' => 'required|string|max:255',
            'specialities_subjects_data.*.*.is_mandatory' => 'required|boolean',
            'specialities_subjects_data.*.*.school_hours' => 'nullable|numeric',
            'specialities_subjects_data.*.*.price' => 'nullable|numeric',
            'specialities_subjects_data.*.*.student_ratio' => 'nullable|numeric',
            'specialities_subjects_data.*.*.remove' => 'required|boolean',
        
            // Validación para subjects_data
            'subjects_data' => 'required|array',
            'subjects_data.*.id' => 'required|exists:subjects_blueprint,id',
            'subjects_data.*.name' => 'required|string|max:255',
            'subjects_data.*.is_mandatory' => 'required|boolean',
            'subjects_data.*.school_hours' => 'required|numeric',
            'subjects_data.*.price' => 'required|numeric',
            'subjects_data.*.student_ratio' => 'required|numeric|min:0',
        ]);

        // Check that the degree is active
        $hasInactiveDegree = DegreeBP::where('id', $validatedData['degree'])
                                    ->where('is_active', false)
                                    ->exists();

        if ($hasInactiveDegree) {
            return redirect()->back()->withErrors([
                'degree' => 'Has seleccionado un grado que está desactivado.'
            ]);
        }

        // Check that the course is active
        $hasInactiveCourse = CourseBP::where('id', $validatedData['course'])
                                    ->where('is_active', false)
                                    ->exists();

        if ($hasInactiveCourse) {
            return redirect()->back()->withErrors([
                'course' => 'Has seleccionado un curso que está desactivado.'
            ]);
        }

        // Check that the specialities are active
        $hasInactiveSpecialities = SpecialityBP::whereIn('id', $validatedData['specialities'])
                                    ->where('is_active', false)
                                    ->exists();

        if ($hasInactiveSpecialities) {
            return redirect()->back()->withErrors([
                'specialities' => 'Has seleccionado especialidades que están desactivadas.'
            ]);
        }

        // Check that the subjects are active
        $hasInactiveSubjects = SubjectBP::whereIn('id', array_keys($validatedData['subjects_data']))
                                    ->where('is_active', false)
                                    ->exists();

        if ($hasInactiveSubjects) {
            return redirect()->back()->withErrors([
                'subjects' => 'Has seleccionado asignaturas que están desactivadas.'
            ]);
        }

        try {
            DB::beginTransaction();

            // Update the syllabi
            $syllabi = SyllabiBP::find($validatedData['id']);
            $syllabi->name = $validatedData['name'];
            $syllabi->age = $validatedData['age'];
            $syllabi->max_failed_subjects_to_pass = $validatedData['max_failed_subjects_to_pass'];
            $syllabi->course_id = $validatedData['course'];
            $syllabi->degree_id = $validatedData['degree'];
            $syllabi->save();

            // Update the specialities
            $syllabi->specialities()->sync($validatedData['specialities']);

            // Update the subjects
            $syncData = [];
            foreach ($validatedData['subjects_data'] as $subjectData) {
                $syncData[$subjectData['id']] = [
                    'is_mandatory' => $subjectData['is_mandatory'],
                    'school_hours' => $subjectData['school_hours'],
                    'price' => $subjectData['price'],
                    'student_ratio' => $subjectData['student_ratio'],
                ];
            }

            // Add speciality subjects to the sync data (only if remove is false)
            foreach ($validatedData['specialities_subjects_data'] as $specialityData) {
                foreach ($specialityData as $subjectData) {
                    if (!$subjectData['remove']) { // Only add if remove is false
                        $syncData[$subjectData['id']] = [
                            'is_mandatory' => $subjectData['is_mandatory'],
                            'school_hours' => $subjectData['school_hours'],
                            'price' => isset($subjectData['price']) ? $subjectData['price'] : null,
                            'is_speciality' => true,
                            'student_ratio' => isset($subjectData['student_ratio']) ? $subjectData['student_ratio'] : null,
                        ];
                    }
                }
            }

            $syllabi->subjects()->sync($syncData);

            DB::commit();

            return redirect()->route('syllabi.show');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Error al actualizar el plan de estudios.');
        }
    }

    /**
     * Delete the syllabi
     */
    public function destroy(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:syllabis_blueprint,id',
        ]);

        try {
            DB::beginTransaction();
            
            // Delete the syllabi
            $syllabi = SyllabiBP::find($validatedData['id']);
            $syllabi->delete();

            // Delete the specialities
            $syllabi->specialities()->detach();

            // Delete the subjects
            $syllabi->subjects()->detach();

            DB::commit();

            return redirect()->route('syllabi.show');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Error al eliminar el plan de estudios.');
        }
    }
}
