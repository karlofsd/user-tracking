<?php

use App\Http\Controllers\Api\LocationApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [UserApiController::class, 'signin']);

Route::get('user', [UserApiController::class, 'index']);

Route::post('user', [UserApiController::class, 'store']);

Route::get('locations', [LocationApiController::class, 'index']);

Route::get('locations/{id}', [LocationApiController::class, 'show']);

Route::put('locations/user/{userId}', [LocationApiController::class, 'update']);

Route::delete('locations/{id}', [LocationApiController::class, 'destroy']);
