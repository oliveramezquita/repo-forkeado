<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin\Invitation;
use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use App\Models\Admin\SchoolYear;
use App\Models\Admin\SchoolSettings;
use App\Models\Scholar\Enrollment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Rules\CustomPasswordRule;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        $today = Carbon::now();
        $settings = SchoolSettings::first();

        if($settings->next_enrollment && $today->gte(Carbon::parse($settings->next_enrollment))) {
            $school_year = SchoolYear::getNextSchoolYear();
        } else {
            $school_year = SchoolYear::getSchoolYear();
        }

        // Get the specialities for the current school year
        $specialities = $school_year->specialities;

        return Inertia::render('Auth/Register', [
            'specialities' => $specialities,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'guardian_name' => 'nullable|string|max:255',
            'guardian_surname' => 'nullable|string|max:255',
            'guardian_birth_date' => 'nullable|date|before:today',
            'guardian_dni' => 'nullable|string|max:9|unique:users,dni|different:student_dni',
            'guardian_phone' => 'nullable|string|max:15',
            'guardian_gender' => 'nullable|in:m,w,o',
            'guardian_email' => 'nullable|string|email|max:255|unique:users,email|unique:invitations,email|different:student_email|different:guardian_others.*',
            'guardian_password' => ['nullable', 'confirmed', new CustomPasswordRule()],
            'guardian_password_confirmation' => ['nullable', new CustomPasswordRule()],
            'guardian_type' => 'nullable|in:father,guardian',

            'guardian_others' => 'nullable|array',
            'guardian_others.*' => 'nullable|string|email|max:255|unique:users,email|unique:invitations,email|different:guardian_email|different:student_email',
            
            'student_name' => 'required|string|max:255',
            'student_surname' => 'required|string|max:255',
            'student_birth_date' => 'required|date|before:today',
            'student_dni' => 'required|string|max:9|unique:users,dni|different:guardian_dni',
            'student_phone' => 'nullable|string|max:15',
            'student_gender' => 'required|in:m,w,o',
            'student_email' => 'required|string|email|max:255|unique:users,email|unique:invitations,email|different:guardian_email|different:guardian_others.*',
            'student_password' => ['required', 'confirmed', new CustomPasswordRule()],
            'student_password_confirmation' => ['required', new CustomPasswordRule()],

            'student_experience_speciality' => 'nullable|numeric|exists:specialities,id',
            'student_experience_years' => 'nullable|numeric|min:0|max:4',

            'student_speciality_option1' => 'required|numeric|exists:specialities,id',
            'student_speciality_option2' => 'nullable|numeric|exists:specialities,id',
            'student_speciality_option3' => 'nullable|numeric|exists:specialities,id',

            'student_availability' => 'nullable|array',
            'student_availability.*' => 'nullable|array',
            'student_availability.*.name' => 'nullable|string',
            'student_availability.*.start' => 'nullable|date_format:H:i',
            'student_availability.*.end' => 'nullable|date_format:H:i|after:student_availability.*.start',
        ]);

        try {
            DB::beginTransaction();

            // Get the school settings and the day of today
            $schoolYear = null;
            $settings = SchoolSettings::first();
            $today = Carbon::now();

            // Check if today's date is greater than current_enrollment
            if ($settings->next_enrollment && $today->gte(Carbon::parse($settings->next_enrollment))) {
                $schoolYear = SchoolYear::getNextSchoolYear();
            } else {
                // Set the current year as the school year to use
                $schoolYear = SchoolYear::getSchoolYear();
            }

            // If the guardian email is set, we try to store it
            if ($request->guardian_email) {
                $guardian = User::create([
                    'email' => $request->guardian_email,
                    'password' => Hash::make($request->guardian_password),
                    'name' => $request->guardian_name,
                    'surname' => $request->guardian_surname,
                    'dni' => $request->guardian_dni,
                    'birth_date' => $request->guardian_birth_date,
                ]);

                // Create a new metadata record for the user
                $guardian->metadata()->create([
                    'phone1' => $request->guardian_phone,
                    'gender' => $request->guardian_gender,
                    'guardian_type' => $request->guardian_type,
                ]);

                // Get the guardian role (loook for the role's name)
                $role = Role::where('name', 'guardian')->first();
                $guardian->assignRole($role);
            }

            // Now we store the student, which always exists
            $student = User::create([
                'email' => $request->student_email,
                'password' => Hash::make($request->student_password),
                'name' => $request->student_name,
                'surname' => $request->student_surname,
                'dni' => $request->student_dni,
                'birth_date' => $request->student_birth_date,
            ]);

            // Create a new metadata record for the student
            // Process the student experience years
            $experience_string = null;
            switch ($request->student_experience_years) {
                case 0:
                    $experience_string = '0-6 meses';
                    break;
                case 1:
                    $experience_string = '1 año';
                    break;
                case 2:
                    $experience_string = '2 años';
                    break;
                case 3:
                    $experience_string = '3 años';
                    break;
                case 4:
                    $experience_string = '4 años o más';
                    break;
                default:
                    $experience_string = null;
                    break;
            }
            $student->metadata()->create([
                'phone1' => $request->student_phone,
                'gender' => $request->student_gender,
                'student_experience_speciality_id' => $request->student_experience_speciality,
                'student_experience_years' => $experience_string,
            ]);

            // Get the student role (loook for the role's name)
            $role = Role::where('name', 'student')->first();
            $student->assignRole($role);

            // We store the enrollment
            do {
                $random = strtoupper(Str::random(10));
                $identifier = preg_replace('/[^A-Z0-9]/', '', $random);
            } while (strlen($identifier) < 10 || Enrollment::identifierExists($identifier));

            $enrollment = $student->enrollments()->create([
                'school_year_id' => $schoolYear->id,
                'identifier' => $identifier,
                'status' => 'pending',
            ]);

            // Now, for each speciality that is not null, we attach it to the enrollment
            foreach ([$request->student_speciality_option1, $request->student_speciality_option2, $request->student_speciality_option3] as $speciality) {
                if ($speciality != null) {
                    $enrollment->specialities()->attach($speciality);
                }
            }

            // Now for all the events of each day, we store them, and at the same time, we attach them to the enrollment
            foreach ($request->student_availability as $abbreviatedDay => $events) {
                $parsedDay = Event::parseDayFromAbbreviation($abbreviatedDay);
                
                if($parsedDay) {
                    foreach ($events as $event) {
                        if($event) {
                            $enrollment->events()->create([
                                'title' => $event['name'],
                                'hour_start' => $event['start'],
                                'hour_end' => $event['end'],
                                'day' => $parsedDay,
                                'type' => 'availability',
                            ]);
                        }
                    }
                }
            }

            // If the guardian is not null, we attach the student to the guardian
            if (isset($guardian) && $guardian != null) {
                $guardian->dependents()->attach($student);
            }

            // Later on, we send an email to the guardian with the link to the registration page, and the hash. 
            // When the guardian clicks on the link, we check if the hash is valid, and if it is, 
            // it continues to the register page with the hash data; the email and the hash data, he just needs to 
            // set the password and confirm it. In the back, we then check the hash to see the corresponding role and
            // the corresponding student, and we attach the guardian to the student.
            if (config('app.env') != 'local') {
                if ($request->guardian_others) {
                    $role = Role::where('name', 'guardian')->first();
                    foreach ($request->guardian_others as $email) {
                        if ($email != null && $email != "") {
                            $combinedString = $email . Str::random(30) . now()->timestamp;
                            $hash = hash('sha256', $combinedString);
                            Invitation::create([
                                'student_id' => $student->id, // Suponiendo que tienes el estudiante en la variable $student
                                'email' => $email,
                                'hash' => $hash,
                                'role_id' => $role->id, // Especifica el rol que deseas
                            ]);
                            // REVIEW: Enviar el email con el hash y la URL de la pagina de registro que acepte el hash por GET
                        }
                    }
                }
            }

            // If after everything is done, there are no errors, we send the email to the student and the guardians
            if (config('app.env') != 'local') {
                event(new Registered($student));
                if (isset($guardian) && $guardian != null) {
                    event(new Registered($guardian));
                }
            } else {
                $student->markEmailAsVerified();
                if (isset($guardian) && $guardian != null) {
                    $guardian->markEmailAsVerified();
                }
            }

            DB::commit();

            // Return to login with a success
            return redirect()->route('login')->with('success', 'Se ha registrado correctamente. Por favor, revise su bandeja de entrada.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Ha ocurrido un error al registrar al usuario. Por favor, inténtelo de nuevo. ' . $e->getMessage());
        }

        // Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);
    }
}
