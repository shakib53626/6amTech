<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\TaskController;
use App\Http\Controllers\User\DashboardController;

// Guest routes
Route::middleware('guest')->group(function () {

    Route::get('/', fn () => redirect()->route('login'));
    Route::get('/login', fn () => Inertia::render('Adminend/Auth/Login'))->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', fn () => Inertia::render('Adminend/Auth/Registration'))->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// User routes
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Tasks
    Route::prefix('/tasks')->name('tasks.')->controller(TaskController::class)->group(function () {
        Route::get('/',          'index')->name('index');
        Route::put('/{id}',      'update')->name('update');
    });
});
