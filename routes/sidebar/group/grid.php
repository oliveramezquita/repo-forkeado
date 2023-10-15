<?php

use App\Http\Controllers\Group\GridController;
use Illuminate\Support\Facades\Route;

Route::prefix('group/grid')->middleware(['auth'])->group(function () {
    
    Route::get('/', [GridController::class, 'show'])->name('group.grid.show');
});
