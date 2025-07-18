<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;


// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {


    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', fn () => Inertia::render('Adminend/Dashboard'))->name('dashboard');

    // Users
    Route::prefix('/users')->name('users.')->controller(UserController::class)->group(function () {
        Route::get('/',          'index')->name('index');
        Route::post('/',         'store')->name('store');
        Route::put('/{id}',      'update')->name('update');
        Route::delete('/{id}',   'destroy')->name('destroy');
    });

    // Tasks
    Route::prefix('/tasks')->name('tasks.')->controller(TaskController::class)->group(function () {
        Route::get('/',          'index')->name('index');
        Route::post('/',         'store')->name('store');
        Route::put('/{id}',      'update')->name('update');
        Route::delete('/{id}',   'destroy')->name('destroy');
    });

    // Categories
    Route::prefix('/categories')->name('categories.')->controller(CategoryController::class)->group(function () {
        Route::get('/',          'index')->name('index');
        Route::post('/',         'store')->name('store');
        Route::put('/{id}',      'update')->name('update');
        Route::delete('/{id}',   'destroy')->name('destroy');
    });

    // Products
    Route::prefix('/products')->name('products.')->controller(ProductController::class)->group(function () {
        Route::get('/',          'index')->name('index');
        Route::post('/',         'store')->name('store');
        Route::put('/{id}',      'update')->name('update');
        Route::delete('/{id}',   'destroy')->name('destroy');
    });
});
