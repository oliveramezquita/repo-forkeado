<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:student.register.show')->only(['show']);
    }

    public function show(Request $request)
    {
        return Inertia::render('Student/RegisterShow');

    }
}
