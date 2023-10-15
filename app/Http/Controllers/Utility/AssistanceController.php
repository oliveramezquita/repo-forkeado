<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AssistanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:utility.assistance.show')->only(['show']);
    }

    public function show(Request $request)
    {
        return Inertia::render('Utility/AssistanceShow');
    }
}
