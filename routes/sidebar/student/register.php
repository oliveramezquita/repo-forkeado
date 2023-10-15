<?php

use App\Http\Controllers\Student\RegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('student/register')->middleware(['auth'])->group(function () {
    
    Route::get('/', [RegisterController::class, 'show'])->name('student.register.show');
});
