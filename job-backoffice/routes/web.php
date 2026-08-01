<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Shared Routes (Admin + Company Owner)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,company-owner'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Job Vacancies
    |--------------------------------------------------------------------------
    */

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

    Route::put('/job-vacancies/{id}/restore', [
        JobVacancyController::class,
        'restore'
    ])->name('job-vacancy.restore');

    /*
    |--------------------------------------------------------------------------
    | Job Applications
    |--------------------------------------------------------------------------
    */

    Route::resource('job-applications', JobApplicationController::class)
        ->names([
            'index' => 'application.index',
            'show' => 'application.show',
            'edit' => 'application.edit',
            'update' => 'application.update',
            'destroy' => 'application.destroy',
        ]);

    Route::put('/job-applications/{id}/restore', [
        JobApplicationController::class,
        'restore'
    ])->name('application.restore');
});


/*
|--------------------------------------------------------------------------
| Company Owner Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:company-owner'])->group(function () {

    Route::get('/my-company', [CompanyController::class, 'showMyCompany'])
        ->name('my-company.show');

    Route::get('/my-company/edit', [CompanyController::class, 'editMyCompany'])
        ->name('my-company.edit');

    Route::put('/my-company', [CompanyController::class, 'updateMyCompany'])
        ->name('my-company.update');
    // Route::put('/my-company', function () {
    //     dd('Route reached');
    // })->name('my-company.update');

});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Companies
    |--------------------------------------------------------------------------
    */

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

    Route::put('/companies/{id}/restore', [
        CompanyController::class,
        'restore'
    ])->name('company.restore');


    /*
    |--------------------------------------------------------------------------
    | Job Categories
    |--------------------------------------------------------------------------
    */

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

    Route::put('/job-categories/{id}/restore', [
        JobCategoryController::class,
        'restore'
    ])->name('category.restore');


    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */

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

    Route::put('/users/{id}/restore', [
        UserController::class,
        'restore'
    ])->name('user.restore');

});


/*
|--------------------------------------------------------------------------
| Profile (All Authenticated Users)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');

});

require __DIR__ . '/auth.php';
