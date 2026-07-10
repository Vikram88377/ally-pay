<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\WalletController;
use App\Http\Controllers\Api\V1\MerchantController;
use App\Http\Controllers\Api\V1\PaymentOrderController;
use App\Http\Controllers\Api\V1\MerchantApiKeyController;
use App\Http\Controllers\Api\V1\Admin\UserController;
use App\Http\Controllers\Api\V1\Admin\MerchantController as AdminMerchantController;


/*
|--------------------------------------------------------------------------
| Local Test Webhook
|--------------------------------------------------------------------------
*/

Route::post('/test-webhook', function (Request $request) {
    return response()->json([
        'success' => true,
        'message' => 'Webhook received successfully',
        'data' => $request->all(),
    ]);
});


Route::prefix('v1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Public Authentication APIs
    |--------------------------------------------------------------------------
    */

    Route::middleware('throttle:auth-api')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
    });


    /*
    |--------------------------------------------------------------------------
    | External Merchant Payment APIs
    |--------------------------------------------------------------------------
    |
    | In routes ko Bearer token nahi chahiye.
    | Merchant public API key ke through authentication hoti hai.
    |
    */

    Route::middleware([
        'merchant.api',
        'throttle:merchant-payment-api',
    ])->group(function () {
        Route::post('/payment-orders', [
            PaymentOrderController::class,
            'store',
        ]);

        Route::post('/payment-orders/verify', [
            PaymentOrderController::class,
            'verify',
        ]);
    });


    /*
    |--------------------------------------------------------------------------
    | Authenticated User APIs
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:api')->group(function () {

        Route::get('/profile', [
            AuthController::class,
            'profile',
        ]);

        Route::post('/logout', [
            AuthController::class,
            'logout',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Authenticated Payment Order API
        |--------------------------------------------------------------------------
        |
        | Policy check is route par chalega.
        | Admin sab orders dekh sakta hai.
        | Merchant sirf apna order dekh sakta hai.
        |
        */

        Route::get('/payment-orders/{paymentOrder}', [
            PaymentOrderController::class,
            'show',
        ])->name('payment-orders.show');


        /*
        |--------------------------------------------------------------------------
        | Wallet APIs
        |--------------------------------------------------------------------------
        */

        Route::middleware('throttle:wallet-api')->group(function () {
            Route::get('/wallet/balance', [
                WalletController::class,
                'balance',
            ]);

            Route::post('/wallet/add-money', [
                WalletController::class,
                'addMoney',
            ]);

            Route::post('/wallet/deduct-money', [
                WalletController::class,
                'deductMoney',
            ]);

            Route::get('/wallet/history', [
                WalletController::class,
                'history',
            ]);

            Route::post('/wallet/transfer', [
                WalletController::class,
                'transfer',
            ]);
        });


        /*
        |--------------------------------------------------------------------------
        | Merchant Account APIs
        |--------------------------------------------------------------------------
        */

        Route::post('/merchant/apply', [
            MerchantController::class,
            'apply',
        ]);

        Route::get('/merchant/me', [
            MerchantController::class,
            'myMerchant',
        ]);

        Route::get('/merchant/api-key', [
            MerchantApiKeyController::class,
            'show',
        ]);

        Route::post('/merchant/api-key/generate', [
            MerchantApiKeyController::class,
            'generate',
        ]);
    });


    /*
    |--------------------------------------------------------------------------
    | Admin APIs
    |--------------------------------------------------------------------------
    */

    Route::middleware([
        'auth:api',
        'role:admin',
    ])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/users', [
                UserController::class,
                'index',
            ]);

            Route::post('/users/{user}/assign-role', [
                UserController::class,
                'assignRole',
            ]);

            Route::get('/merchants', [
                AdminMerchantController::class,
                'index',
            ]);

            Route::patch('/merchants/{id}/status', [
                AdminMerchantController::class,
                'updateStatus',
            ]);
        });
});