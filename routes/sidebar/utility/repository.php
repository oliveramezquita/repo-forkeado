<?php

use App\Http\Controllers\Utility\RepositoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('utility/repository')->middleware(['auth'])->group(function () {
    
    Route::get('/', [RepositoryController::class, 'show'])->name('utility.repository.show');
});
