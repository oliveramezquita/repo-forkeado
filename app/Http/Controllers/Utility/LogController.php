<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:utility.log.show')->only(['show']);
    }

    public function show(Request $request)
    {
        // Create a random collection of logs data with the following structure
        // Username, Usersurname, Model (like: Create User), Hour, Date
        $logs = [
            [
                'id' => 1,
                'user' => [
                    'name' => 'John',
                    'surname' => 'Doe'
                ],
                'model' => 'Create User',
                'hour' => '12:00',
                'date' => '2021-01-01'
            ],
            [
                'id' => 2,
                'user' => [
                    'name' => 'John',
                    'surname' => 'Doe'
                ],
                'model' => 'Create User',
                'hour' => '12:00',
                'date' => '2021-01-01'
            ],
            [
                'id' => 3,
                'user' => [
                    'name' => 'John',
                    'surname' => 'Doe'
                ],
                'model' => 'Create User',
                'hour' => '12:00',
                'date' => '2021-01-01'
            ],
            [
                'id' => 4,
                'user' => [
                    'name' => 'John',
                    'surname' => 'Doe'
                ],
                'model' => 'Create User',
                'hour' => '12:00',
                'date' => '2021-01-01'
            ],
            [
                'id' => 5,
                'user' => [
                    'name' => 'John',
                    'surname' => 'Doe'
                ],
                'model' => 'Create User',
                'hour' => '12:00',
                'date' => '2021-01-01'
            ],
            [
                'id' => 6,
                'user' => [
                    'name' => 'John',
                    'surname' => 'Doe'
                ],
                'model' => 'Create User',
                'hour' => '12:00',
                'date' => '2021-01-01'
            ],
            [
                'id' => 7,
                'user' => [
                    'name' => 'John',
                    'surname' => 'Doe'
                ],
                'model' => 'Create User',
                'hour' => '12:00',
                'date' => '2021-01-01'
            ],
            [
                'id' => 8,
                'user' => [
                    'name' => 'John',
                    'surname' => 'Doe'
                ],
                'model' => 'Create User',
                'hour' => '12:00',
                'date' => '2021-01-01'
            ],
        ];
        
        return Inertia::render('Utility/LogShow', [
            'logs' => $logs
        ]);
    }
}
