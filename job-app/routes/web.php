<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationsController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/job-applications', [JobApplicationsController::class, 'index'])->name('job-applications.index');
    Route::get('/job-vacancies/{id}', [JobVacancyController::class, 'show'])->name('job-vacancies.show');
    Route::get('/job-vacancies/{id}/apply', [JobVacancyController::class, 'apply'])->name('job-vacancies.apply');
    Route::post('/job-vacancies/{id}/apply', [JobVacancyController::class, 'processApplication'])->name('job-vacancies.process-application');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::get('/test-gemini', [JobVacancyController::class, 'testGemini'])
    // ->name('test-gemini');

    // TEST OPENAI
    Route::get('/test-openai', [JobVacancyController::class, 'testOpenAI'])->name('test-openai');

    Route::get('/test-openrouter', [JobVacancyController::class, 'testOpenRouter'])
    ->name('test-openrouter');
});

require __DIR__.'/auth.php';
