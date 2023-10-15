<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:utility.calendar.show')->only(['show']);
    }

    public function show(Request $request)
    {
        return Inertia::render('Utility/CalendarShow');
    }
}
