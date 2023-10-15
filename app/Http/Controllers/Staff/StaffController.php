<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:staff.show')->only(['show']);
    }

    public function show(Request $request)
    {
        // Get all the users with the role of student
        $teachers = User::getTeachers();

        // Create a new collection with the students and their guardians.
        $teachersWithAdditionalData = $teachers->map(function ($teacher) {
            return [
                'id' => $teacher->id,
                'email' => $teacher->email,
                'photo_url' => $teacher->photo_url,
                'name' => $teacher->name,
                'surname' => $teacher->surname,
                'dni' => $teacher->dni,
                'birth_date' => $teacher->birth_date,
                'positions' => $teacher->positions->map(function ($position) {
                    return [
                        'id' => $position->id,
                        'name' => $position->name,
                    ];
                }),
            ];
        });
        return Inertia::render('Staff/Show', [
            'teachers' => $teachersWithAdditionalData,
        ]);
    }
}
