<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => Inertia::render('Adminend/Auth/Login'))->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', fn () => Inertia::render('Adminend/Auth/Registration'))->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => Inertia::render('Adminend/Dashboard'))->name('dashboard');
    Route::get('/dashboard', fn () => Inertia::render('Adminend/Dashboard'));
});
