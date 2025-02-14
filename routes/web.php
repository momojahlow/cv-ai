<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\CurriculumController;
use Inertia\Inertia;
use App\Http\Controllers\CorrectorSection;

Route::get('/', function () {
    return redirect()->route('login');
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/cv', CorrectorSection::class)->name('cv');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');


    Route::get('/cv-pdf', CorrectorSection::class)->name('cv-pdf');

    Route::get('/curriculum', [CurriculumController::class, 'index'])->name('curriculum.index');
    Route::post('/curriculum/correct-summary', [CurriculumController::class, 'correctSummary'])->name('curriculum.correct-summary');
    Route::post('/curriculum/update-resume', [CurriculumController::class, 'updateResume'])->name('curriculum.update-resume');
    Route::post('/curriculum/update-profile', [CurriculumController::class, 'updateProfile'])->name('curriculum.update-profile');

    Route::post('/education', [EducationController::class, 'store'])->name('education.store');
    Route::delete('/education/{education}', [EducationController::class, 'destroy'])->name('education.destroy');

    Route::get('/experiences', [ExperienceController::class, 'index'])->name('experiences');
    Route::get('/experience/create', [ExperienceController::class, 'create'])->name('experience.create');
    Route::post('/experience/store', [ExperienceController::class, 'store'])->name('experience.store');
    Route::get('/experience/{id}/edit', [ExperienceController::class, 'edit'])->name('experience.edit');
    Route::put('/experience/{id}/update', [ExperienceController::class, 'update'])->name('experience.update');
    Route::delete('/experience/{id}/delete', [ExperienceController::class, 'destroy'])->name('experience.destroy');
    Route::post('/experience/correct-description', [ExperienceController::class, 'correctDescription'])->name('experience.correct-description');
});
