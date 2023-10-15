<?php

use App\Http\Controllers\Group\GroupController;
use Illuminate\Support\Facades\Route;

Route::prefix('groups')->middleware(['auth'])->group(function () {
    
    Route::get('/', [GroupController::class, 'show'])->name('group.show');
});
