<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\MerchantApiKey;

class VerifyMerchantApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'API key is required',
            ], 401);
        }

        $merchantKey = MerchantApiKey::with('merchant')
            ->where('public_key', $apiKey)
            ->where('is_active', true)
            ->first();

        if (!$merchantKey) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API key',
            ], 401);
        }

        if ($merchantKey->merchant->status !== 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Merchant is not approved',
            ], 403);
        }

        $request->merge([
            'merchant' => $merchantKey->merchant,
        ]);

        return $next($request);
    }
}