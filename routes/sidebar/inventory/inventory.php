<?php

use App\Http\Controllers\Inventory\InventoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('inventory')->middleware(['auth'])->group(function () {
    
    Route::get('/', [InventoryController::class, 'show'])->name('inventory.show');
});
