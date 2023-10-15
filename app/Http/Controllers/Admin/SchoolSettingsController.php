<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\SchoolSettings;
use App\Models\Admin\SchoolYear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Validator;

class SchoolSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:school.settings.store')->only('store');
        $this->middleware('can:school.settings.edit')->only('edit');
        $this->middleware('can:school.settings.update')->only('update');
    }

    /**
     * Display the school settings to create them
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Admin/SchoolSettings/Create');
    }

    /**
     * Store the school settings
     */
    public function store(Request $request) {

        $validator = dataValidation($request);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        dateValidation($request);

        if (dateValidation($request) != null) {
            return;
        }

        // Get the year of the initial enrollment opening
        $current_year = date('Y', strtotime($request->input('starting_time')));

        // Create the current scholar year
        SchoolYear::createScholarYear($current_year);

        // Create the next scholar year
        SchoolYear::createNextScholarYear();

        try {
            SchoolSettings::create([
                'school_name' => $request->input('school_name'),
                'school_name_short' => $request->input('school_name_short') ? $request->input('school_name_short') : '',
                'school_address' => $request->input('school_address'),
                'school_phone' => $request->input('school_phone'),
                'school_cif' => $request->input('school_cif'),
                'school_email' => $request->input('school_email'),
                'school_web' => $request->input('school_web') ? $request->input('school_web') : '',
                'school_logo' => $request->input('school_logo') ? $request->input('school_logo') : '',

                // Schooling
                'subjects_to_pass' => $request->input('subjects_to_pass'),
                'previous_subject_passed' => $request->input('previous_subject_passed'),

                // Inventory
                'max_loans' => $request->input('max_loans'),

                // Finance
                'max_annual_instalments_fees' => $request->input('max_annual_instalments_fees'),

                // Scholar year
                'current_enrollment' => $request->input('current_enrollment'),
                'end_current_enrollment' => $request->input('end_current_enrollment'),
                'next_enrollment' => $request->input('next_enrollment'),
                'end_next_enrollment' => $request->input('end_next_enrollment'),
                'starting_time' => $request->input('starting_time'),
                'ending_time' => $request->input('ending_time'),
            ]);

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            \Log::error('Excepción al crear ajustes del centro: ' . $e->getMessage());
            return redirect()->back()->withErrors('Error al crear los ajustes del centro.');
        }

    }


    /**
     * Display the school settings to either edit or create them
     */
    public function edit(Request $request)
    {
        $settings = SchoolSettings::first();

        return Inertia::render('Admin/SchoolSettings/Edit', [
            'settings' => $settings,
        ]);
    }

    /**
     * Update the school settings
     */
    public function update(Request $request) {

        $validator = dataValidation($request);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->toArray());
        }

        if (dateValidation($request) != null) {
            return;
        }
        
        $settings = SchoolSettings::first();

        try {
            $settings->update([
                'school_name' => $request->input('school_name'),
                'school_name_short' => $request->input('school_name_short') ? $request->input('school_name_short') : '',
                'school_address' => $request->input('school_address'),
                'school_phone' => $request->input('school_phone'),
                'school_cif' => $request->input('school_cif'),
                'school_email' => $request->input('school_email'),
                'school_web' => $request->input('school_web') ? $request->input('school_web') : '',
                'school_logo' => $request->input('school_logo') ? $request->input('school_logo') : '',

                // Schooling
                'subjects_to_pass' => $request->input('subjects_to_pass'),
                'previous_subject_passed' => $request->input('previous_subject_passed'),

                // Inventory
                'max_loans' => $request->input('max_loans'),

                // Finance
                'max_annual_instalments_fees' => $request->input('max_annual_instalments_fees'),

                // Scholar year
                'current_enrollment' => $request->input('current_enrollment'),
                'end_current_enrollment' => $request->input('end_current_enrollment'),
                'next_enrollment' => $request->input('next_enrollment'),
                'end_next_enrollment' => $request->input('end_next_enrollment'),
                'starting_time' => $request->input('starting_time'),
                'ending_time' => $request->input('ending_time'),
            ]);

            return redirect()->back()->with('success', '¡Ajustes del centro actualizados correctamente!');
        }
        catch (\Exception $e) {
            return redirect()->back()->withErrors('Error al actualizar los ajustes del centro.');
        }

    }

}

    /*
    * Create a function to unificate all the date validation
    */
    function dateValidation($request)
    {
        // General date validation for all the school types
        if ($request->input('next_enrollment') && $request->input('current_enrollment')) {
            if ($request->input('next_enrollment') <= $request->input('current_enrollment')) {
                return redirect()->back()->withErrors('La fecha de apertura de matrícula debe ser mayor que la fecha de apertura de matrícula inicial.');
            }
        }
        if ($request->input('starting_time') <= $request->input('current_enrollment')) {
            return redirect()->back()->withErrors('La fecha de comienzo de curso debe ser mayor que la fecha de apertura de matrícula inicial.');
        }
        if ($request->input('ending_time') <= $request->input('starting_time')) {
            return redirect()->back()->withErrors('La fecha de finalización de curso debe ser mayor que la fecha de comienzo de curso.');
        }
        if (date('Y', strtotime($request->input('current_enrollment'))) != date('Y')) {
            return redirect()->back()->withErrors('La fecha de apertura de matrícula inicial debe ser del año actual.');
        }
        if ($request->input('next_enrollment')) {
            $current_enrollment_year = date('Y', strtotime($request->input('current_enrollment')));
            $next_enrollment_year = date('Y', strtotime($request->input('next_enrollment')));
            if ($next_enrollment_year != $current_enrollment_year + 1) {
                return redirect()->back()->withErrors('La fecha de apertura de matrícula debe ser un año más que la fecha de apertura de matrícula inicial.');
            }
        }

        // Specific data validation for cons
        if (config('app.type') == 'cons') {
            if ($request->input('end_current_enrollment')) {
                if ($request->input('end_current_enrollment') <= $request->input('current_enrollment')) {
                    return redirect()->back()->withErrors('La fecha de cierre de matrícula debe ser mayor que la fecha de apertura.');
                } elseif ($request->input('end_current_enrollment') >= $request->input('starting_time')) {
                    return redirect()->back()->withErrors('La fecha de cierre de matrícula debe ser menor que la fecha de comienzo de curso.');
                }
                return redirect()->back()->withErrors('La fecha de cierre de matrícula no puede ser nula.');
            } else {
                return redirect()->back()->withErrors('La fecha de cierre de matrícula no puede ser nula.');
            }

            if ($request->input('end_next_enrollment')) {
                if ($request->input('end_next_enrollment') <= $request->input('next_enrollment')) {
                    return redirect()->back()->withErrors('La fecha de cierre de matrícula siguiente debe ser mayor que la fecha de apertura.');
                }
            }
        }

        // Si todas las validaciones pasan, puedes devolver algo como esto o simplemente no hacer nada.
        return null;
    }

    /*
    * Validates the data of the request
    */
    function dataValidation($request)
    {
        $rules = [
            "school_name" => "required|string",
            "school_name_short" => "nullable|string",
            "school_address" => "required|string",
            "school_phone" => "required|string",
            "school_cif" => "required|string",
            "school_email" => "required|email",
            "school_web" => "nullable|url",
            "school_logo" => "nullable|url",

            "subjects_to_pass" => "required|numeric",
            "previous_subject_passed" => "required|boolean",

            "max_loans" => "required|numeric",

            "max_annual_instalments_fees" => "required|numeric",

            "current_enrollment" => "required|date",
            "end_current_enrollment" => "nullable|date",
            "next_enrollment" => "nullable|date",
            "end_next_enrollment" => "nullable|date",
            "starting_time" => "required|date",
            "ending_time" => "required|date",
        ];

        $validator = Validator::make($request->all(), $rules);

        return $validator;
    }
