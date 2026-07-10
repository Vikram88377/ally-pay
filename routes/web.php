<?php

use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\Web\Admin\AuthController;
use App\Http\Controllers\Web\Admin\UserController;
use App\Http\Controllers\Web\Admin\WalletController;
use App\Http\Controllers\Web\Admin\ReportController;
use App\Http\Controllers\Web\Admin\WebhookController;
use App\Http\Controllers\Web\Admin\MerchantController;
use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\AuditLogController;
use App\Http\Controllers\Web\Admin\PaymentOrderController;

// Merchant Controllers
use App\Http\Controllers\Web\Merchant\ApiKeyController;
use App\Http\Controllers\Web\Merchant\AuthController as MerchantAuthController;
use App\Http\Controllers\Web\Merchant\DashboardController as MerchantDashboardController;
use App\Http\Controllers\Web\Merchant\PaymentOrderController as MerchantPaymentOrderController;
use App\Http\Controllers\Web\Merchant\WebhookSettingController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');


/*
|--------------------------------------------------------------------------
| Merchant Web Panel
|--------------------------------------------------------------------------
*/

Route::prefix('merchant')
    ->name('merchant.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Merchant Guest Routes
        |--------------------------------------------------------------------------
        */

        Route::get('/login', [
            MerchantAuthController::class,
            'showLogin',
        ])->name('login');

        Route::post('/login', [
            MerchantAuthController::class,
            'login',
        ])->name('login.submit');


        /*
        |--------------------------------------------------------------------------
        | Merchant Protected Routes
        |--------------------------------------------------------------------------
        */

        Route::middleware(['auth', 'merchant.web'])
            ->group(function () {

                Route::get('/dashboard', [
                    MerchantDashboardController::class,
                    'index',
                ])->name('dashboard');

                Route::post('/logout', [
                    MerchantAuthController::class,
                    'logout',
                ])->name('logout');
                    Route::get(
    '/webhook-settings',
    [WebhookSettingController::class, 'index']
)->name('webhook-settings.index');


Route::post(
    '/webhook-settings',
    [WebhookSettingController::class, 'store']
)->name('webhook-settings.store');

                /*
                |--------------------------------------------------------------------------
                | Merchant Payments
                |--------------------------------------------------------------------------
                */

                Route::get('/payments', [
                    MerchantPaymentOrderController::class,
                    'index',
                ])->name('payments.index');

                Route::get('/payments/{paymentOrder}', [
                    MerchantPaymentOrderController::class,
                    'show',
                ])->name('payments.show');


                /*
                |--------------------------------------------------------------------------
                | Merchant API Keys
                |--------------------------------------------------------------------------
                */

                Route::get('/api-keys', [
                    ApiKeyController::class,
                    'index',
                ])->name('api-keys.index');

                Route::post('/api-keys/regenerate', [
                    ApiKeyController::class,
                    'regenerate',
                ])->name('api-keys.regenerate');
            });
    });


/*
|--------------------------------------------------------------------------
| Admin Web Panel
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Admin Guest Routes
        |--------------------------------------------------------------------------
        */

        Route::get('/login', [
            AuthController::class,
            'showLogin',
        ])->name('login');

        Route::post('/login', [
            AuthController::class,
            'login',
        ])->name('login.submit');


        /*
        |--------------------------------------------------------------------------
        | Admin Protected Routes
        |--------------------------------------------------------------------------
        */

        Route::middleware(['auth', 'admin.web'])
            ->group(function () {

                Route::get('/dashboard', [
                    DashboardController::class,
                    'index',
                ])->name('dashboard');

                Route::post('/logout', [
                    AuthController::class,
                    'logout',
                ])->name('logout');


                /*
                |--------------------------------------------------------------------------
                | Users
                |--------------------------------------------------------------------------
                */

                Route::get('/users', [
                    UserController::class,
                    'index',
                ])->name('users.index');

                Route::get('/users/{user}', [
                    UserController::class,
                    'show',
                ])->name('users.show');

                Route::post('/users/{user}/assign-role', [
                    UserController::class,
                    'assignRole',
                ])->name('users.assign-role');


                /*
                |--------------------------------------------------------------------------
                | Merchants
                |--------------------------------------------------------------------------
                */

                Route::get('/merchants', [
                    MerchantController::class,
                    'index',
                ])->name('merchants.index');

                Route::get('/merchants/{merchant}', [
                    MerchantController::class,
                    'show',
                ])->name('merchants.show');

                Route::post('/merchants/{merchant}/status', [
                    MerchantController::class,
                    'updateStatus',
                ])->name('merchants.update-status');


                /*
                |--------------------------------------------------------------------------
                | Payments
                |--------------------------------------------------------------------------
                */

                Route::get('/payments', [
                    PaymentOrderController::class,
                    'index',
                ])->name('payments.index');

                Route::get('/payments/{paymentOrder}', [
                    PaymentOrderController::class,
                    'show',
                ])->name('payments.show');


                /*
                |--------------------------------------------------------------------------
                | Wallets
                |--------------------------------------------------------------------------
                */

                Route::get('/wallets', [
                    WalletController::class,
                    'index',
                ])->name('wallets.index');

                Route::get('/wallet-transactions', [
                    WalletController::class,
                    'transactions',
                ])->name('wallets.transactions');


                /*
                |--------------------------------------------------------------------------
                | Webhooks
                |--------------------------------------------------------------------------
                */

                Route::get('/webhooks', [
                    WebhookController::class,
                    'index',
                ])->name('webhooks.index');

                Route::get('/webhooks/{webhookEvent}', [
                    WebhookController::class,
                    'show',
                ])->name('webhooks.show');

                Route::post('/webhooks/{webhookEvent}/retry', [
                    WebhookController::class,
                    'retry',
                ])->name('webhooks.retry');


                /*
                |--------------------------------------------------------------------------
                | Audit Logs
                |--------------------------------------------------------------------------
                */

                Route::get('/audit-logs', [
                    AuditLogController::class,
                    'index',
                ])->name('audit-logs.index');

                Route::get('/audit-logs/{auditLog}', [
                    AuditLogController::class,
                    'show',
                ])->name('audit-logs.show');


                /*
                |--------------------------------------------------------------------------
                | Reports
                |--------------------------------------------------------------------------
                */

                Route::get('/reports/payments', [
                    ReportController::class,
                    'payments',
                ])->name('reports.payments');

                Route::get('/reports/payments/export', [
                    ReportController::class,
                    'exportPayments',
                ])->name('reports.payments.export');

                Route::get('/reports/transactions', [
                    ReportController::class,
                    'transactions',
                ])->name('reports.transactions');

                Route::get('/reports/transactions/export', [
                    ReportController::class,
                    'exportTransactions',
                ])->name('reports.transactions.export');
            });
    });