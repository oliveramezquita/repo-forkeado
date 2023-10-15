<?php

use App\Http\Controllers\Grouping\RehearsalController;
use Illuminate\Support\Facades\Route;

Route::prefix('grouping/rehearsals')->middleware(['auth'])->group(function () {
    
    Route::get('/', [RehearsalController::class, 'show'])->name('grouping.rehearsal.show');
});
