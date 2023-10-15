<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GridController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:group.grid.show')->only(['show']);
    }

    public function show(Request $request)
    {
        return Inertia::render('Group/GridShow');

    }
}
