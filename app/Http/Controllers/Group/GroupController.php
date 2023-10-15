<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:group.show')->only(['show']);
    }

    public function show(Request $request)
    {
        // Create a random collection of groups with the following fields:
        // ID, Name, Degree, Subject, Teacher, Classroom, Date, hour start, hour end, students, max students, and the students that are in the group.
        // For each student, show the ID, the photo_url and the name and surname
        $url = config('app.url');
        $groups = [
            [
                'id' => 1,
                'name' => '1º A',
                'degree' => 'Elemental',
                'subject' => 'Lenguaje Musical',
                'teacher' => 'Antonio Lopez',
                'classroom' => 'Aula 3',
                'date' => 'LUN',
                'start_hour' => '08:00',
                'end_hour' => '09:00',
                'active_students' => '6',
                'max_students' => '20',
                'color' => '#1414b8',
                'students' => [
                    [
                        'id' => 1,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                    [
                        'id' => 2,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                    [
                        'id' => 3,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                    [
                        'id' => 4,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                    [
                        'id' => 5,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                    [
                        'id' => 6,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                ],
            ],
            [
                'id' => 2,
                'name' => '1º A',
                'degree' => 'Elemental',
                'subject' => 'Lenguaje Musical',
                'teacher' => 'Antonio Lopez',
                'classroom' => 'Aula 3',
                'date' => 'LUN',
                'start_hour' => '08:00',
                'end_hour' => '09:00',
                'active_students' => '6',
                'max_students' => '20',
                'color' => '#1414b8',
                'students' => [
                    [
                        'id' => 1,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                    [
                        'id' => 2,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                    [
                        'id' => 3,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                    [
                        'id' => 4,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                    [
                        'id' => 5,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                    [
                        'id' => 6,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                ],
            ],
            [
                'id' => 3,
                'name' => '1º A',
                'degree' => 'Elemental',
                'subject' => 'Lenguaje Musical',
                'teacher' => 'Antonio Lopez',
                'classroom' => 'Aula 3',
                'date' => 'LUN',
                'start_hour' => '08:00',
                'end_hour' => '09:00',
                'active_students' => '6',
                'max_students' => '20',
                'color' => '#1414b8',
                'students' => [
                    [
                        'id' => 1,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                    [
                        'id' => 2,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                    [
                        'id' => 3,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                    [
                        'id' => 4,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                    [
                        'id' => 5,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                    [
                        'id' => 6,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                ],
            ],
            [
                'id' => 4,
                'name' => '1º A',
                'degree' => 'Elemental',
                'subject' => 'Lenguaje Musical',
                'teacher' => 'Antonio Lopez',
                'classroom' => 'Aula 3',
                'date' => 'LUN',
                'start_hour' => '08:00',
                'end_hour' => '09:00',
                'active_students' => '6',
                'max_students' => '20',
                'color' => '#1414b8',
                'students' => [
                    [
                        'id' => 1,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                    [
                        'id' => 2,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                    [
                        'id' => 3,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                    [
                        'id' => 4,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                    [
                        'id' => 5,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                    [
                        'id' => 6,
                        'name' => 'Juan',
                        'surname' => 'Perez',
                        'photo_url' => $url . '/storage/sample_avatar.jpeg',
                    ],
                ],
            ],
        ];


        return Inertia::render('Group/Show', [
            'groups' => $groups,
        ]);

    }
}
