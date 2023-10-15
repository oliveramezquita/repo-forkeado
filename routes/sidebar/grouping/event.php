<?php

use App\Http\Controllers\Grouping\EventController;
use Illuminate\Support\Facades\Route;

Route::prefix('grouping/events')->middleware(['auth'])->group(function () {
    
    Route::get('/', [EventController::class, 'show'])->name('grouping.event.show');
});
