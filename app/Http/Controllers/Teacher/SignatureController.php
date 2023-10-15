<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SignatureController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:teacher.signature.show')->only(['show']);
    }

    public function show(Request $request)
    {
        // Create a collection of signatures with the following fields:
        // Id, Date, Hour, Start Hour, End Hour, Status ['Absent', 'Pending', 'Present'].
        $signatures = [
            [
                'id' => 1,
                'date' => '2021-01-01',
                'hour' => '09:05',
                'start_hour' => '09:00',
                'end_hour' => '10:00',
                'status' => 'peding'
            ],
            [
                'id' => 2,
                'date' => '2021-01-01',
                'signature_hour' => '08:10',
                'start_hour' => '08:00',
                'end_hour' => '09:00',
                'status' => 'absent'
            ],
            [
                'id' => 3,
                'date' => '2021-01-01',
                'hour' => '09:05',
                'start_hour' => '09:00',
                'end_hour' => '10:00',
                'status' => 'absent'
            ],
            [
                'id' => 4,
                'date' => '2021-01-01',
                'hour' => '10:01',
                'start_hour' => '10:00',
                'end_hour' => '11:00',
                'status' => 'present'
            ],
            [
                'id' => 5,
                'date' => '2021-01-01',
                'hour' => '11:15',
                'start_hour' => '11:00',
                'end_hour' => '12:00',
                'status' => 'present'
            ],
        ];

        // Si es un movil renderiza la otra vista
        $frontParams = [
            'signatures' => $signatures,
        ];
        if (app('isMobile')) {
            return Inertia::render('Teacher/Mobile/SignatureShow', $frontParams);
        } else {
            return Inertia::render('Teacher/SignatureShow', $frontParams);
        }
    }
}
