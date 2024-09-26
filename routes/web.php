<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortofolioController;

/* Public Routes */
Route::get('/', [PortofolioController::class, 'showPortofolio'])->name('portofolio page');
Route::get('/login', [PortofolioController::class, 'showLogin'])->name('login page');
Route::post('/login', [PortofolioController::class, 'login'])->name('login');

/* Private Routes - protected by 'auth' middleware */
Route::middleware('auth')->group(function () {
    Route::get('/editor', [PortofolioController::class, 'showEditor'])->name('editor page');
    Route::post('/logout', [PortofolioController::class, 'logout'])->name('logout');
});
