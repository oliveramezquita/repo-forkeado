<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    $data = [
        "accumulative_hours" => [
            "hours" => 30,
            "minutes" => 40,
            "month" => 8,
        ],
        "assistence" => "80%",
        "subjects_in_charge" => 8,
        "messages_unread" => 5,
        "completition_percentage" => 65,
        "average_mark" => 8.5,
    ];

    $events = [
        "signature" => [
            [
                "date" => "2021-08-01",
                "title" => "Lenguaje Musical",
                "hour" => "08:00",
                "status" => "pending",
            ],
            [
                "date" => "2021-08-01",
                "title" => "Música 1",
                "hour" => "17:00",
                "status" => "scheduled",
            ],
            [
                "date" => "2021-08-01",
                "title" => "Música 1",
                "hour" => "19:00",
                "status" => "scheduled",
            ],
        ],
        "marks" => [
            [
                "date" => "2021-08-01",
                "title" => "1º B Elemental",
                "desc" => "Examen Lenguaje Musical",
            ],
            [
                "date" => "2021-08-01",
                "title" => "1º A Elemental",
                "desc" => "Examen Lenguaje Musical",
            ],
        ],
        "tests" => [
            [
                "date" => "2021-08-01",
                "title" => "Inglés",
                "start_hour" => "18:30",
                "end_hour" => "19:30"
            ],
            [
                "date" => "2021-08-01",
                "title" => "Lenguaje Musical 2",
                "start_hour" => "18:30",
                "end_hour" => "19:30"
            ],
        ],
        "timetable" => [
            [
                "date" => "2021-08-01",
                "title" => "Lenguaje Musical",
                "start_hour" => "18:30",
                "end_hour" => "19:30"
            ],
            [
                "date" => "2021-08-01",
                "title" => "Instrumentos de viento",
                "start_hour" => "18:30",
                "end_hour" => "19:30"
            ],
            [
                "date" => "2021-08-01",
                "title" => "Lenguaje Musical",
                "start_hour" => "18:30",
                "end_hour" => "19:30"
            ],
        ],
        "events" => [
            [
                "date" => "2021-08-01",
                "title" => "Concierto de Navidad",
                "start_hour" => "18:30",
                "end_hour" => "19:30"
            ],
            [
                "date" => "2021-08-01",
                "title" => "Concierto Musical",
                "start_hour" => "18:30",
                "end_hour" => "19:30"
            ],
            [
                "date" => "2021-08-01",
                "title" => "Concierto de Chocolate",
                "start_hour" => "18:30",
                "end_hour" => "19:30"
            ],
        ],
    ];

    // Si es un movil renderiza la otra vista
    $frontParams = [
        'data' => $data,
        'events' => $events,
    ];
    if (app('isMobile')) {
        return Inertia::render('Mobile/Dashboard', $frontParams);
    } else {
        return Inertia::render('Dashboard', $frontParams);
    }
})->middleware(['auth', 'verified'])->name('dashboard');



// Authentication
require __DIR__.'/authentication/auth.php';
require __DIR__.'/authentication/metadata.php';





// HEADER
require __DIR__.'/header/settings.php';
require __DIR__.'/header/messaging.php';





// SIDEBAR

// Group
require __DIR__.'/sidebar/group/group.php';
require __DIR__.'/sidebar/group/individual.php';
require __DIR__.'/sidebar/group/grid.php';
require __DIR__.'/sidebar/group/schedule.php';


// Syllabi
require __DIR__.'/sidebar/syllabi/syllabi.php';
require __DIR__.'/sidebar/syllabi/elements.php';
require __DIR__.'/sidebar/syllabi/department.php';

// Student
require __DIR__.'/sidebar/student/student.php';
require __DIR__.'/sidebar/student/register.php';
require __DIR__.'/sidebar/student/request.php';

// Staff
require __DIR__.'/sidebar/staff/staff.php';
require __DIR__.'/sidebar/staff/diary.php';
require __DIR__.'/sidebar/staff/substitution.php';

// Grouping
require __DIR__.'/sidebar/grouping/grouping.php';
require __DIR__.'/sidebar/grouping/member.php';
require __DIR__.'/sidebar/grouping/instrument.php';
require __DIR__.'/sidebar/grouping/event.php';
require __DIR__.'/sidebar/grouping/rehearsal.php';
require __DIR__.'/sidebar/grouping/sheet.php';

// Inventory
require __DIR__.'/sidebar/inventory/inventory.php';
require __DIR__.'/sidebar/inventory/log.php';

// Evaluation
require __DIR__.'/sidebar/evaluation/evaluation.php';
require __DIR__.'/sidebar/evaluation/session.php';
require __DIR__.'/sidebar/evaluation/statistic.php';

// Teacher
require __DIR__.'/sidebar/teacher/diary.php';
require __DIR__.'/sidebar/teacher/signature.php';

// Finance
if (config('app.type') == 'school') {
    require __DIR__.'/sidebar/finance/balance.php';
    require __DIR__.'/sidebar/finance/income.php';
    require __DIR__.'/sidebar/finance/outcome.php';
}

// Utility
require __DIR__.'/sidebar/utility/calendar.php';
require __DIR__.'/sidebar/utility/schedule.php';
require __DIR__.'/sidebar/utility/repository.php';
require __DIR__.'/sidebar/utility/incidence.php';
require __DIR__.'/sidebar/utility/classroom.php';
require __DIR__.'/sidebar/utility/log.php';
require __DIR__.'/sidebar/utility/assistance.php';

// Help
require __DIR__.'/sidebar/help/tutorial.php';
require __DIR__.'/sidebar/help/support.php';
require __DIR__.'/sidebar/help/suggestion.php';
