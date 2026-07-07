<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\Admin\UserController;
use App\Http\Controllers\Api\V1\WalletController;
Route::prefix('v1')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/wallet/balance', [WalletController::class, 'balance']);
    Route::post('/wallet/add-money', [WalletController::class, 'addMoney']);
    Route::post('/wallet/deduct-money', [WalletController::class, 'deductMoney']);
    Route::get('/wallet/history', [WalletController::class, 'history']);
    Route::post('/wallet/transfer', [WalletController::class, 'transfer']);
    });

        Route::middleware(['auth:api', 'role:admin'])->prefix('admin')->group(function () {

        Route::get('/users', [UserController::class, 'index']);

        Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole']);

    });

});