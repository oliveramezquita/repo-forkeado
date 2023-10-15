<?php

namespace App\Http\Controllers\Messaging;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MessagingController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:messaging.show')->only(['show']);
    }

    public function show(Request $request)
    {
        return Inertia::render('Messaging/Show');

    }
}
