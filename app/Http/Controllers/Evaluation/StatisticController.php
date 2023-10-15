<?php

namespace App\Http\Controllers\Evaluation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StatisticController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:evaluation.statistic.show')->only(['show']);
    }

    public function show(Request $request)
    {
        return Inertia::render('Evaluation/StatisticShow');
    }
}
