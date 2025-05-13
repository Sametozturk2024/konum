<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationsController;
use App\Http\Controllers\Api\ApiAuthController;

Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::get('/user', [ApiAuthController::class, 'user']);
    Route::post('/logout', [ApiAuthController::class, 'logout']);

    Route::post('/add-location', [LocationsController::class, 'store']);
    Route::get('/get-locations', [LocationsController::class, 'index']);
    Route::get('/get-location/{id}', [LocationsController::class, 'show'])->where('id', '[0-9]+');
    Route::put('/edit-location/{id}', [LocationsController::class, 'update'])->where('id', '[0-9]+');
    Route::delete('/destroy-location/{id}', [LocationsController::class, 'destroy'])->where('id', '[0-9]+');
    Route::post('/maps', [LocationsController::class, 'maps']);
});
