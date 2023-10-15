<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:inventory.log.show')->only(['show']);
    }

    public function show(Request $request)
    {
        return Inertia::render('Inventory/LogShow');
    }
}
