<?php

use App\Http\Controllers\Teacher\DiaryController;
use Illuminate\Support\Facades\Route;

Route::prefix('teacher/diary')->middleware(['auth'])->group(function () {
    
    Route::get('/', [DiaryController::class, 'show'])->name('teacher.diary.show');
});
