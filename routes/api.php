<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationsController;
use App\Http\Controllers\Api\ApiAuthController;


Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);


Route::middleware(['auth:sanctum','throttle:api'])->group(function () {
    Route::get('/user', [ApiAuthController::class, 'user']);
    Route::post('/logout', [ApiAuthController::class, 'logout']);


    Route::post('/add-location', [LocationsController::class, 'store']);
    Route::get('/get-locations', [LocationsController::class, 'index']);
    Route::get('/get-location/{slug}', [LocationsController::class, 'show']);
    Route::post('/edit-location/{slug}', [LocationsController::class, 'update']);
    Route::post('/destroy-location/{slug}', [LocationsController::class, 'destroy']);
    Route::get('/routing/{slug}', [LocationsController::class, 'routing']);


});
