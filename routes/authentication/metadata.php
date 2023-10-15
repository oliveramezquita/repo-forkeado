<?php

use App\Http\Controllers\MetadataController;
use Illuminate\Support\Facades\Route;

Route::prefix('metadata')->middleware(['auth'])->group(function () {
    
    Route::get('/', [MetadataController::class, 'edit'])->name('metadata.edit');
    Route::patch('/', [MetadataController::class, 'update'])->name('metadata.update');
});
