<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DiaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:teacher.diary.show')->only(['show']);
    }

    public function show(Request $request)
    {
        return Inertia::render('Teacher/DiaryShow');
    }
}
