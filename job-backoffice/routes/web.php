<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');


    // Companies
    Route::resource('companies', CompanyController::class)
        ->names([
            'index' => 'company.index',
            'create' => 'company.create',
            'store' => 'company.store',
            'show' => 'company.show',
            'edit' => 'company.edit',
            'update' => 'company.update',
            'destroy' => 'company.destroy',
        ]);


    // Job Applications
    Route::get('/job-applications', [
        JobApplicationController::class,
        'index'
    ])->name('application.index');


    // Job Categories
    Route::resource('job-categories', JobCategoryController::class)
        ->names([
            'index' => 'category.index',
            'create' => 'category.create',
            'store' => 'category.store',
            'show' => 'category.show',
            'edit' => 'category.edit',
            'update' => 'category.update',
            'destroy' => 'category.destroy',
        ]);


    // Job Vacancies
    Route::resource('job-vacancies', JobVacancyController::class)
        ->names([
            'index' => 'job-vacancy.index',
            'create' => 'job-vacancy.create',
            'store' => 'job-vacancy.store',
            'show' => 'job-vacancy.show',
            'edit' => 'job-vacancy.edit',
            'update' => 'job-vacancy.update',
            'destroy' => 'job-vacancy.destroy',
        ]);


    // Users
    Route::resource('users', UserController::class)
        ->names([
            'index' => 'user.index',
            'create' => 'user.create',
            'store' => 'user.store',
            'show' => 'user.show',
            'edit' => 'user.edit',
            'update' => 'user.update',
            'destroy' => 'user.destroy',
        ]);


    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


require __DIR__.'/auth.php';
