<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\TaskController;

Route::controller(ApiAuthController::class)->group(function () {
    Route::post('/login',     'login'   );
    Route::post('/register',  'register');
});

Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [ApiAuthController::class, 'logout']);

    // Tasks
    Route::prefix('/tasks')->name('tasks.')->controller(TaskController::class)->group(function () {
        Route::get('/',          'index')->name('index');
        Route::post('/',         'store')->name('store');
        Route::put('/{id}',      'update')->name('update');
        Route::delete('/{id}',   'destroy')->name('destroy');
    });
});
