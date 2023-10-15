<?php

namespace App\Http\Controllers\Evaluation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EvaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:evaluation.show')->only(['show']);
    }

    public function show(Request $request)
    {
        return Inertia::render('Evaluation/Show');
    }
}
