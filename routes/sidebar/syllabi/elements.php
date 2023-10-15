<?php

use App\Http\Controllers\Syllabi\CourseController;
use App\Http\Controllers\Syllabi\DegreeController;
use App\Http\Controllers\Syllabi\SpecialityController;
use App\Http\Controllers\Syllabi\SubjectController;
use Illuminate\Support\Facades\Route;

Route::prefix('degree')->middleware(['auth'])->group(function () {
    Route::post('/', [DegreeController::class, 'store'])->name('degree.store');
    Route::patch('/', [DegreeController::class, 'update'])->name('degree.update');
    Route::delete('/', [DegreeController::class, 'destroy'])->name('degree.destroy');
    Route::patch('/activate', [DegreeController::class, 'activate'])->name('degree.activate');
});

Route::prefix('course')->middleware(['auth'])->group(function () {
    Route::post('/', [CourseController::class, 'store'])->name('course.store');
    Route::patch('/', [CourseController::class, 'update'])->name('course.update');
    Route::delete('/', [CourseController::class, 'destroy'])->name('course.destroy');
    Route::patch('/activate', [CourseController::class, 'activate'])->name('course.activate');
});

Route::prefix('speciality')->middleware(['auth'])->group(function () {
    Route::post('/', [SpecialityController::class, 'store'])->name('speciality.store');
    Route::patch('/', [SpecialityController::class, 'update'])->name('speciality.update');
    Route::delete('/', [SpecialityController::class, 'destroy'])->name('speciality.destroy');
    Route::patch('/activate', [SpecialityController::class, 'activate'])->name('speciality.activate');
});

Route::prefix('subject')->middleware(['auth'])->group(function () {
    Route::post('/', [SubjectController::class, 'store'])->name('subject.store');
    Route::patch('/', [SubjectController::class, 'update'])->name('subject.update');
    Route::delete('/', [SubjectController::class, 'destroy'])->name('subject.destroy');
    Route::patch('/activate', [SubjectController::class, 'activate'])->name('subject.activate');
});