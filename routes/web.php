<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\AuthController;
use App\Http\Controllers\Web\Admin\UserController;
use App\Http\Controllers\Web\Admin\MerchantController;
use App\Http\Controllers\Web\Admin\PaymentOrderController;
use App\Http\Controllers\Web\Admin\WalletController;
use App\Http\Controllers\Web\Admin\WebhookController;
use App\Http\Controllers\Web\Admin\AuditLogController;
use App\Http\Controllers\Web\Admin\ReportController;



Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/audit-logs', [AuditLogController::class, 'index'])
    ->name('audit-logs.index');

Route::get('/audit-logs/{auditLog}', [AuditLogController::class, 'show'])
    ->name('audit-logs.show');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

Route::get('/merchants', [MerchantController::class, 'index'])->name('merchants.index');
Route::get('/merchants/{merchant}', [MerchantController::class, 'show'])->name('merchants.show');
Route::post('/merchants/{merchant}/status', [MerchantController::class, 'updateStatus'])->name('merchants.update-status');
Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assign-role');
Route::get('/payments', [PaymentOrderController::class, 'index'])->name('payments.index');
Route::get('/payments/{paymentOrder}', [PaymentOrderController::class, 'show'])->name('payments.show');
Route::get('/wallets', [WalletController::class, 'index'])->name('wallets.index');
Route::get('/wallet-transactions', [WalletController::class, 'transactions'])->name('wallets.transactions');
Route::get('/webhooks', [WebhookController::class, 'index'])->name('webhooks.index');
Route::get('/webhooks/{webhookEvent}', [WebhookController::class, 'show'])->name('webhooks.show');
Route::post('/webhooks/{webhookEvent}/retry', [WebhookController::class, 'retry'])
    ->name('webhooks.retry');
Route::get('/reports/payments', [ReportController::class, 'payments'])
    ->name('reports.payments');

Route::get('/reports/payments/export', [ReportController::class, 'exportPayments'])
    ->name('reports.payments.export');

Route::get('/reports/transactions', [ReportController::class, 'transactions'])
    ->name('reports.transactions');

Route::get('/reports/transactions/export', [ReportController::class, 'exportTransactions'])
    ->name('reports.transactions.export');
    
Route::middleware(['auth', 'admin.web'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
});