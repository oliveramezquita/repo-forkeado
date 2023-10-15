<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:student.show')->only(['show']);
    }

    public function show(Request $request)
    {
        // Get all the users with the role of student
        $students = User::getStudents();

        // Create a new collection with the students and their guardians.
        $studentsWithAdditionalData = $students->map(function ($student) {
            return [
                'id' => $student->id,
                'email' => $student->email,
                'photo_url' => $student->photo_url,
                'name' => $student->name,
                'surname' => $student->surname,
                'dni' => $student->dni,
                'birth_date' => $student->birth_date,
                'guardian' => $student->guardians->first() ? [
                    'id' => $student->guardians->first()->id,
                    'email' => $student->guardians->first()->email,
                    'photo_url' => $student->guardians->first()->photo_url,
                    'name' => $student->guardians->first()->name,
                    'surname' => $student->guardians->first()->surname,
                    'dni' => $student->guardians->first()->dni,
                    'birth_date' => $student->guardians->first()->birth_date,
                ] : null,
            ];
        });
        
        return Inertia::render('Student/Show', [
            'students' => $studentsWithAdditionalData,
        ]);
    }
}
