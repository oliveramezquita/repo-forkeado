<?php

use App\Http\Controllers\Student\StudentController;
use Illuminate\Support\Facades\Route;

Route::prefix('student')->middleware(['auth'])->group(function () {
    
    Route::get('/', [StudentController::class, 'show'])->name('student.show');
});
