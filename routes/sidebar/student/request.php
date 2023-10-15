<?php

use App\Http\Controllers\Student\RequestController;
use Illuminate\Support\Facades\Route;

Route::prefix('student/requests')->middleware(['auth'])->group(function () {
    
    Route::get('/', [RequestController::class, 'show'])->name('student.request.show');
});
