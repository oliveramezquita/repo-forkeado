<?php

use App\Http\Controllers\Inventory\LogController;
use Illuminate\Support\Facades\Route;

Route::prefix('inventory/log')->middleware(['auth'])->group(function () {
    
    Route::get('/', [LogController::class, 'show'])->name('inventory.log.show');
});
