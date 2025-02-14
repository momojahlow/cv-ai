<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\CurriculumController;
use Inertia\Inertia;
use App\Http\Controllers\CurriculumGenerator;

Route::get('/', function () {
    return redirect()->route('login');
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/cv', CurriculumGenerator::class)->name('cv');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/cv-pdf', CurriculumGenerator::class)->name('cv-pdf');

    Route::middleware(['auth'])->group(function () {
        Route::get('/curriculum', [CurriculumController::class, 'index'])->name('curriculum.index');
        Route::post('/curriculum/profile', [CurriculumController::class, 'updateProfile'])->name('curriculum.profile.update');
        Route::post('/curriculum/resume', [CurriculumController::class, 'updateResume'])->name('curriculum.resume.update');
        Route::post('/curriculum/languages', [CurriculumController::class, 'updateLanguages'])->name('curriculum.language.update');
        Route::post('/curriculum/correct-resume', [CurriculumController::class, 'correctResume'])->name('curriculum.resume.correct');        
        Route::post('/curriculum/update-profile', [CurriculumController::class, 'updateProfile'])->name('curriculum.update-profile');

        // Experience routes
        Route::get('/experience/create', [ExperienceController::class, 'create'])->name('experience.create');
        Route::post('/experience', [ExperienceController::class, 'store'])->name('experience.store');
        Route::put('/experience/{experience}', [ExperienceController::class, 'update'])->name('experience.update');
        Route::delete('/experience/{experience}', [ExperienceController::class, 'destroy'])->name('experience.destroy');
        // Route::get('/experiences', [ExperienceController::class, 'index'])->name('experiences');    
        // Route::get('/experience/{id}/edit', [ExperienceController::class, 'edit'])->name('experience.edit');
        // Route::put('/experience/{id}/update', [ExperienceController::class, 'update'])->name('experience.update');
        // Route::delete('/experience/{id}/delete', [ExperienceController::class, 'destroy'])->name('experience.destroy');
    });

    

    Route::post('/education', [EducationController::class, 'store'])->name('education.store');
    Route::delete('/education/{education}', [EducationController::class, 'destroy'])->name('education.destroy');

    
    // Route::post('/experience/correct-description', [ExperienceController::class, 'correctDescription'])->name('experience.correct-description');
});
