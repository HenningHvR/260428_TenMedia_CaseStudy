<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Zeigt die öffentliche Startseite an.
Route::view('/', 'welcome')->name('home');

// Zeigt das Dashboard nach erfolgreichem Login an.
Route::view('/dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Fasst alle Routen zusammen, die nur eingeloggte User nutzen dürfen.
Route::middleware('auth')->group(function () {

    // Breeze-Profilrouten für das eigene Userprofil.
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Resource-Routen für Kategorien.
    Route::resource('categories', CategoryController::class);

    // Resource-Routen für Companies.
    Route::resource('companies', CompanyController::class);

    // Resource-Routen für JobPostings.
    // Der Parameter wird auf jobPosting gesetzt, damit das Route Model Binding zum Controller passt.
    Route::resource('job-postings', JobPostingController::class)
        ->parameters([
            'job-postings' => 'jobPosting',
        ]);

    // Resource-Routen für die Userverwaltung.
    // User-Erstellung erfolgt über Breeze, daher nur Anzeige und Bearbeitung.
    Route::resource('users', UserController::class)
        ->only([
            'index',
            'show',
            'edit',
            'update',
        ]);
});

// Lädt die Auth-Routen von Laravel Breeze.
require __DIR__ . '/auth.php';

