<?php

use App\Http\Controllers\Syllabi\ElementsController;
use App\Http\Controllers\Syllabi\SyllabiController;
use Illuminate\Support\Facades\Route;

Route::prefix('syllabi')->middleware(['auth'])->group(function () {
    Route::get('/elements', [ElementsController::class, 'elements_show'])->name('syllabi.elements.show');
    
    Route::get('/', [ElementsController::class, 'show'])->name('syllabi.show');
    Route::get('/create', [SyllabiController::class, 'create'])->name('syllabi.create');
    Route::post('/create', [SyllabiController::class, 'store'])->name('syllabi.store');
    Route::get('/edit/{syllabi}', [SyllabiController::class, 'edit'])->name('syllabi.edit');
    Route::patch('/edit', [SyllabiController::class, 'update'])->name('syllabi.update');
    Route::delete('/edit', [SyllabiController::class, 'destroy'])->name('syllabi.destroy');
});