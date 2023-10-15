<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GroupIndividualController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:group.individual.show')->only(['show']);
    }

    public function show(Request $request)
    {
        return Inertia::render('Group/IndividualShow');

    }
}
