<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => Inertia::render('Adminend/Auth/Login'))->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => Inertia::render('Adminend/Dashboard'))->name('dashboard');
    Route::get('/dashboard', fn () => Inertia::render('Adminend/Dashboard'));
});
