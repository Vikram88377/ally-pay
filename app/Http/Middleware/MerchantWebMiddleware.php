<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MerchantWebMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->hasRole('merchant')) {
            abort(403, 'Only merchant users can access this page');
        }

        if (!$user->merchant) {
            abort(403, 'Merchant profile not found');
        }

        if ($user->merchant->status !== 'approved') {
            abort(403, 'Merchant account is not approved');
        }

        return $next($request);
    }
}