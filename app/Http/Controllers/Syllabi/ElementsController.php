<?php

namespace App\Http\Controllers\Syllabi;

use App\Http\Controllers\Controller;
use App\Models\Admin\SchoolSettings;
use App\Models\Department;
use App\Models\Syllabi\SyllabiBP\CourseBP;
use App\Models\Syllabi\SyllabiBP\DegreeBP;
use App\Models\Syllabi\SyllabiBP\SpecialityBP;
use App\Models\Syllabi\SyllabiBP\SubjectBP;
use App\Models\Admin\SchoolYear;
use App\Models\Syllabi\SyllabiBP\SyllabiBP;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class ElementsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:syllabi.elements.show')->only('elements_show');
        $this->middleware('can:syllabi.show')->only('show');
    }

    /**
     * Display the elements that can be used to make a syllabi
     */
    public function elements_show(Request $request)
    {
        // Retrieve all the elements
        $courses = CourseBP::all();
        $coursesDict = CourseBP::allowedNamesToDict();
        $degrees = DegreeBP::all();
        $subjects = SubjectBP::whereNull('speciality_id')->get();
        $specialities = SpecialityBP::all();
        $departments = Department::all();
        $teachersData = Role::where('name', 'teacher')->first()->users;
        
        $teachers = $teachersData->map(function ($user) {
            return $user->only(['id', 'name', 'surname', 'email']);
        });

        // For each speciality, I want to obtain the departmen_id from one of their subjects
        $specialitiesWithAdditionalData = $specialities->map( function ($speciality) {
            return [
                'id' => $speciality->id,
                'name' => $speciality->name,
                'department_id' => $speciality->subjects->first()->department_id,
                'is_active' => $speciality->is_active,
            ];
        })->toArray();

        return Inertia::render('Syllabi/Elements', [
            'courses' => $courses,
            'coursesDict' => $coursesDict,
            'degrees' => $degrees,
            'subjects' => $subjects,
            'specialities' => $specialitiesWithAdditionalData,
            'departments' => $departments,
            'teachers' => $teachers,
            'customroute' => "syllabi.elements.show",
        ]);
    }

    public function show(Request $request)
    {
        // Obtain the day of today
        $today = Carbon::now();

        // Obtain the settings
        $settings = SchoolSettings::first();
        $edit_current_year = null;

        $current_year = SchoolYear::getSchoolYear();

        // If there are syllabis archived already (it means that the enrollment has been surpassed at least once) or the current enrollment is over, we show the archived syllabis for the current year, otherwise we show the active ones
        if(($settings->current_enrollment && $today->gte(Carbon::parse($settings->current_enrollment))) || count($current_year->syllabis) > 0) {
            $edit_current_year = false;

            $current_syllabis = $current_year->syllabis;
        } else {
            $edit_current_year = true;

            $current_syllabis = SyllabiBP::all();
        }

        $current_syllabiWithAdditionalData = $current_syllabis->map(function ($syllabi) {
            return [
                'id' => $syllabi->id,
                'name' => $syllabi->name,
                'course' => $syllabi->course->number,
                'degree' => $syllabi->degree->name,
                'specialities' => $syllabi->specialities->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'name' => $s->name,
                    ];
                })->toArray(),
                'subjects' => $syllabi->subjects->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'name' => $s->name,
                        'department' => $s->department->name ?? 'Sin Departamento',
                        'is_mandatory' => $s->pivot->is_mandatory,
                        'school_hours' => $s->pivot->school_hours,
                        'price' => $s->pivot->price,
                        'is_collective' => $s->is_collective,
                        'student_ratio' => $s->pivot->student_ratio,
                    ];
                })->toArray(),
                'is_active' => $syllabi->is_active,
            ];
        });
        

        // If the current enrollment is over, we may me able to create next year syllabis or see them
        if($settings->current_enrollment && $today->gte(Carbon::parse($settings->current_enrollment))) {

            // Get the next school year
            $next_year = SchoolYear::getNextSchoolYear();

            if ($next_year) {

                $edit_next_year = null;

                // If there are syllabis already archived for the next year or the next_enrollment is in the past, then we can't edit the incoming year
                if (($settings->next_enrollment && $today->gte(Carbon::parse($settings->next_enrollment))) || count($next_year->syllabis) > 0) {
                    $edit_next_year = false;

                    $next_syllabis = $next_year->syllabis;
                } else {
                    $edit_next_year = true;

                    $next_syllabis = SyllabiBP::all();
                }

                $next_syllabiWithAdditionalData = $next_syllabis->map(function ($syllabi) {
                    return [
                        'id' => $syllabi->id,
                        'name' => $syllabi->name,
                        'course' => $syllabi->course->number,
                        'degree' => $syllabi->degree->name,
                        'specialities' => $syllabi->specialities->map(function ($s) {
                            return [
                                'id' => $s->id,
                                'name' => $s->name,
                            ];
                        })->toArray(),
                        'subjects' => $syllabi->subjects->map(function ($s) {
                            return [
                                'id' => $s->id,
                                'name' => $s->name,
                                'department' => $s->department->name ?? 'Sin Departamento',
                                'is_mandatory' => $s->pivot->is_mandatory,
                                'school_hours' => $s->pivot->school_hours,
                                'price' => $s->pivot->price,
                                'is_collective' => $s->is_collective,
                                'student_ratio' => $s->pivot->student_ratio,
                            ];
                        })->toArray(),
                        'is_active' => $syllabi->is_active,
                    ];
                });
            }
        }

        return Inertia::render('Syllabi/Syllabi', [
            'current_year' => $current_year,
            'edit_current_year' => $edit_current_year,
            'current_syllabis' => $current_syllabiWithAdditionalData,

            'next_year' => $next_year ?? null,
            'edit_next_year' => $edit_next_year ?? null,
            'next_syllabis' => $next_syllabiWithAdditionalData ?? null,
            
            'customroute' => "syllabi.show",
        ]);
    }
}
