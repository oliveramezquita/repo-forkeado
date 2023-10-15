<?php

use App\Http\Controllers\Staff\DiaryController;
use Illuminate\Support\Facades\Route;

Route::prefix('staff/diary')->middleware(['auth'])->group(function () {
    
    Route::get('/', [DiaryController::class, 'show'])->name('staff.diary.show');
});
