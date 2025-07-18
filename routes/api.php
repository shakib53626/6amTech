<?php

use App\Http\Controllers\Api\ApiAuthController;

Route::controller(ApiAuthController::class)->group(function () {
    Route::post('/login',     'login'   );
    Route::post('/register',  'register');
});

Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [ApiAuthController::class, 'logout']);
});
