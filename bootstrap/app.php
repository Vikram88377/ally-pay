<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use App\Http\Middleware\VerifyMerchantApiKey;
use App\Http\Middleware\AdminWebMiddleware;
use App\Exceptions\InsufficientBalanceException;
use App\Exceptions\WalletNotFoundException;
use App\Exceptions\MerchantNotApprovedException;
use Illuminate\Http\Request;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
      $middleware->alias([
        'role' => RoleMiddleware::class,
           'merchant.api' => VerifyMerchantApiKey::class,
            'admin.web' => AdminWebMiddleware::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
         $exceptions->render(function (
        InsufficientBalanceException $e,
        Request $request
    ) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    });

    $exceptions->render(function (
        WalletNotFoundException $e,
        Request $request
    ) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
        }
    });

    $exceptions->render(function (
        MerchantNotApprovedException $e,
        Request $request
    ) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 403);
        }
    });
    })->create();
