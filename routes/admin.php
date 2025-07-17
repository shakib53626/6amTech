<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', fn () => Inertia::render('Adminend/Dashboard'))->name('dashboard');

    // Users
    Route::prefix('/users')->name('users.')->controller(UserController::class)->group(function () {
        Route::get('/',          'index')->name('index');
        Route::post('/',         'store')->name('store');
        Route::put('/{id}',      'update')->name('update');
        Route::delete('/{id}',   'destroy')->name('destroy');
    });
});
