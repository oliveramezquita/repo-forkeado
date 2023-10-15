<?php

use App\Http\Controllers\Group\GridController;
use App\Http\Controllers\Group\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::prefix('group/schedule')->middleware(['auth'])->group(function () {
    
    Route::get('/', [ScheduleController::class, 'show'])->name('group.schedule.show');
});
