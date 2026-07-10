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
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
          $middleware->append(SecurityHeaders::class);
      $middleware->alias([
        'role' => RoleMiddleware::class,
           'merchant.api' => VerifyMerchantApiKey::class,
            'admin.web' => AdminWebMiddleware::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
          $exceptions->render(function (
        AuthenticationException $e,
        Request $request
    ) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }
    });

    $exceptions->render(function (
        ValidationException $e,
        Request $request
    ) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    });

    $exceptions->render(function (
        ModelNotFoundException $e,
        Request $request
    ) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found',
            ], 404);
        }
    });

    $exceptions->render(function (
        NotFoundHttpException $e,
        Request $request
    ) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'API route not found',
            ], 404);
        }
    });

    $exceptions->render(function (
        AccessDeniedHttpException $e,
        Request $request
    ) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to perform this action',
            ], 403);
        }
    });

    $exceptions->render(function (
        TooManyRequestsHttpException $e,
        Request $request
    ) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Too many requests. Please try again later',
            ], 429);
        }
    });

    $exceptions->render(function (
        Throwable $e,
        Request $request
    ) {
        if ($request->expectsJson()) {

            report($e);

            return response()->json([
                'success' => false,
                'message' => app()->isProduction()
                    ? 'Internal server error'
                    : $e->getMessage(),
            ], 500);
        }
    });
    })->create();
