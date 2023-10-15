<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OutcomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:finance.outcome.show')->only(['show']);
    }

    public function show(Request $request)
    {
        return Inertia::render('Finance/OutcomeShow');
    }
}
