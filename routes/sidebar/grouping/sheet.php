<?php

use App\Http\Controllers\Grouping\SheetController;
use Illuminate\Support\Facades\Route;

Route::prefix('grouping/sheets')->middleware(['auth'])->group(function () {
    
    Route::get('/', [SheetController::class, 'show'])->name('grouping.sheet.show');
});
