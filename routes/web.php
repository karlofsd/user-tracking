<?php

use App\Http\Controllers\Api\LocationApiController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {

    Route::get('login', [AuthController::class, 'login'])->name('login');

    Route::post('login', [AuthController::class, 'signin']);

    Route::get('register', [AuthController::class, 'register'])->name('register');

    Route::post('register', [AuthController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/', [AuthController::class, 'logout'])->name('logout');
    Route::post('/locations/user/{userId}', [HomeController::class, 'updateLocation']);
});
