<?php

namespace App\Http\Controllers\Help;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SuggestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:help.suggestion.show')->only(['show']);
    }

    public function show(Request $request)
    {
        return Inertia::render('Help/SuggestionShow');
    }
}
