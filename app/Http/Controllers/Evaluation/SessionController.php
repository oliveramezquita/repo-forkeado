<?php

namespace App\Http\Controllers\Evaluation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:evaluation.session.show')->only(['show']);
    }

    public function show(Request $request)
    {
        return Inertia::render('Evaluation/SessionShow');
    }
}
