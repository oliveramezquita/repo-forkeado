<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DiaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:staff.diary.show')->only(['show']);
    }

    public function show(Request $request)
    {
        return Inertia::render('Staff/DiaryShow');
    }
}
