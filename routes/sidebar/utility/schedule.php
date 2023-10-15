<?php

use App\Http\Controllers\Utility\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::prefix('utility/schedule')->middleware(['auth'])->group(function () {
    
    Route::get('/', [ScheduleController::class, 'show'])->name('utility.schedule.show');
});
