<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\Admin\UserController;
Route::prefix('v1')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

        Route::middleware(['auth:api', 'role:admin'])->prefix('admin')->group(function () {

        Route::get('/users', [UserController::class, 'index']);

        Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole']);

    });

});