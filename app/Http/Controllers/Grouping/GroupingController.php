<?php

namespace App\Http\Controllers\Grouping;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GroupingController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:grouping.show')->only(['show']);
    }

    public function show(Request $request)
    {
        return Inertia::render('Grouping/Show');
    }
}
