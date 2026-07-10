<?php

namespace App\Http\Middleware;

use App\Models\MerchantApiKey;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class VerifyMerchantApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        $publicKey = $request->header('X-API-KEY');
        $secretKey = $request->header('X-API-SECRET');


        /*
        |--------------------------------------------------------------------------
        | Missing Credentials
        |--------------------------------------------------------------------------
        */

        if (!$publicKey || !$secretKey) {

            Log::channel('security')->warning(
                'Merchant API credentials missing',
                [
                    'ip' => $request->ip(),
                    'path' => $request->path(),
                    'public_key' => $publicKey,
                ]
            );

            return response()->json([
                'success' => false,
                'message' => 'API key and secret key are required',
            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | Find Active API Key
        |--------------------------------------------------------------------------
        */

        $merchantKey = MerchantApiKey::with('merchant')
            ->where('public_key', $publicKey)
            ->where('is_active', true)
            ->first();


        if (!$merchantKey) {

            Log::channel('security')->warning(
                'Invalid merchant public key',
                [
                    'ip' => $request->ip(),
                    'path' => $request->path(),
                    'public_key' => $publicKey,
                ]
            );

            return response()->json([
                'success' => false,
                'message' => 'Invalid API credentials',
            ], 401);
        }



        /*
        |--------------------------------------------------------------------------
        | Verify Secret Hash
        |--------------------------------------------------------------------------
        */

        if (!Hash::check(
            $secretKey,
            $merchantKey->secret_key
        )) {


            Log::channel('security')->warning(
                'Invalid merchant secret key',
                [
                    'ip' => $request->ip(),
                    'path' => $request->path(),
                    'merchant_id' => $merchantKey->merchant_id,
                ]
            );


            return response()->json([
                'success' => false,
                'message' => 'Invalid API credentials',
            ], 401);
        }



        /*
        |--------------------------------------------------------------------------
        | Merchant Check
        |--------------------------------------------------------------------------
        */

        if (!$merchantKey->merchant) {


            Log::channel('security')->warning(
                'Merchant profile missing',
                [
                    'api_key_id' => $merchantKey->id,
                    'ip' => $request->ip(),
                ]
            );


            return response()->json([
                'success' => false,
                'message' => 'Merchant profile not found',
            ], 404);
        }



        /*
        |--------------------------------------------------------------------------
        | Approval Check
        |--------------------------------------------------------------------------
        */

        if ($merchantKey->merchant->status !== 'approved') {


            Log::channel('security')->warning(
                'Unapproved merchant API access attempt',
                [
                    'merchant_id' => $merchantKey->merchant->id,
                    'status' => $merchantKey->merchant->status,
                    'ip' => $request->ip(),
                    'path' => $request->path(),
                ]
            );


            return response()->json([
                'success' => false,
                'message' => 'Merchant is not approved',
            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | Attach Merchant To Request
        |--------------------------------------------------------------------------
        */

        $request->attributes->set(
            'merchant',
            $merchantKey->merchant
        );


        $request->attributes->set(
            'merchant_api_key',
            $merchantKey
        );


        return $next($request);
    }
}