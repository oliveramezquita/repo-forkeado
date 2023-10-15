<?php

use App\Http\Controllers\Utility\ClassroomController;
use Illuminate\Support\Facades\Route;

Route::prefix('utility/classrooms')->middleware(['auth'])->group(function () {
    
    Route::get('/', [ClassroomController::class, 'show'])->name('utility.classroom.show');
});
