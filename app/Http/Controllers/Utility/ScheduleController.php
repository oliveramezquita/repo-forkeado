<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:utility.schedule.show')->only(['show']);
    }

    public function show(Request $request)
    {
        return Inertia::render('Utility/ScheduleShow');
    }
}
