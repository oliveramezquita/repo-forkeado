<?php

use App\Http\Controllers\Utility\CalendarController;
use Illuminate\Support\Facades\Route;

Route::prefix('utility/calendar')->middleware(['auth'])->group(function () {
    
    Route::get('/', [CalendarController::class, 'show'])->name('utility.calendar.show');
});
