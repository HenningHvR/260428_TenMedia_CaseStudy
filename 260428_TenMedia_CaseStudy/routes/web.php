<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Öffentliche Startseite
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard nach Login
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Geschützte Routen für eingeloggte User
Route::middleware('auth')->group(function () {

    // Breeze-Profilrouten
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Case-Study Resource-Routen
    Route::resource('job-postings', JobPostingController::class)
        ->parameters([
            'job-postings' => 'jobPosting',
        ]);

    Route::resource('companies', CompanyController::class);

    Route::resource('categories', CategoryController::class);

    Route::resource('users', UserController::class)
        ->only([
            'index',
            'show',
            'edit',
            'update',
        ]);
});

require __DIR__.'/auth.php';
