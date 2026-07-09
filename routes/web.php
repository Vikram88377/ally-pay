<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\AuthController;
use App\Http\Controllers\Web\Admin\UserController;
use App\Http\Controllers\Web\Admin\MerchantController;
Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

Route::get('/merchants', [MerchantController::class, 'index'])->name('merchants.index');
Route::get('/merchants/{merchant}', [MerchantController::class, 'show'])->name('merchants.show');
Route::post('/merchants/{merchant}/status', [MerchantController::class, 'updateStatus'])->name('merchants.update-status');
Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assign-role');

Route::middleware(['auth', 'admin.web'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
});