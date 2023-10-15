<?php

use App\Http\Controllers\Group\GroupIndividualController;
use Illuminate\Support\Facades\Route;

Route::prefix('group/individual')->middleware(['auth'])->group(function () {
    
    Route::get('/', [GroupIndividualController::class, 'show'])->name('group.individual.show');
});
