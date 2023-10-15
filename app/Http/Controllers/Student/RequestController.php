<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:student.request.show')->only(['show']);
    }

    public function show(Request $request)
    {
        return Inertia::render('Student/RequestShow');

    }
}
