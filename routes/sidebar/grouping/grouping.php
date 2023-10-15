<?php

use App\Http\Controllers\Grouping\GroupingController;
use Illuminate\Support\Facades\Route;

Route::prefix('grouping')->middleware(['auth'])->group(function () {
    
    Route::get('/', [GroupingController::class, 'show'])->name('grouping.show');
});
