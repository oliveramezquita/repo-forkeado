<?php

use App\Http\Controllers\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::prefix('department')->middleware(['auth'])->group(function () {
    
    Route::get('/', [DepartmentController::class, 'show'])->name('department.show');
    Route::post('/', [DepartmentController::class, 'store'])->name('department.store');
    Route::patch('/', [DepartmentController::class, 'update'])->name('department.update');
    Route::delete('/', [DepartmentController::class, 'destroy'])->name('department.destroy');
    Route::patch('/activate', [DepartmentController::class, 'activate'])->name('department.activate');

    Route::post('/subject', [DepartmentController::class, 'store_subject'])->name('department.subject.store');
    Route::delete('/subject', [DepartmentController::class, 'destroy_subject'])->name('department.subject.destroy');
});