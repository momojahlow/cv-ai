<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExperienceController;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('login');
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/curriculum', function () {
        $user = auth()->user();
        $userInfo = [
            'name' => $user->name,
            'email' => $user->email,
            'title' => 'Développeur Full Stack', // You might want to make this dynamic
            'categories' => ['Web', 'Mobile', 'Backend'],
            'birthDate' => '1990-01-01', // Get this from curriculum if exists
            'nationality' => 'Française', // Get this from curriculum if exists
            'familyStatus' => 'Célibataire', // Get this from curriculum if exists
            'educationLevel' => 'Bac+5', // Get this from curriculum if exists
            'address' => 'Paris, France', // Get this from curriculum if exists
            'summary' => '', // Get this from curriculum if exists
        ];

        return Inertia::render('Curriculum/Index', [
            'userInfo' => $userInfo,
            'auth' => [
                'user' => $user
            ]
        ]);
    })->name('curriculum.index');

    Route::get('/experiences', [ExperienceController::class, 'index'])->name('experiences');
    Route::get('/experience/create', [ExperienceController::class, 'create'])->name('experience.create');
    Route::post('/experience/store', [ExperienceController::class, 'store'])->name('experience.store');
    Route::get('/experience/{id}/edit', [ExperienceController::class, 'edit'])->name('experience.edit');
    Route::put('/experience/{id}/update', [ExperienceController::class, 'update'])->name('experience.update');
    Route::delete('/experience/{id}/delete', [ExperienceController::class, 'destroy'])->name('experience.destroy');
    Route::post('/experience/correct-description', [ExperienceController::class, 'correctDescription'])->name('experience.correct-description');
});
