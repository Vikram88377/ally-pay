<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\MerchantApiKeyService;
use Illuminate\Http\Request;
use Exception;

class MerchantApiKeyController extends Controller
{
    public function __construct(
        protected MerchantApiKeyService $apiKeyService
    ) {}

    public function show(Request $request)
    {
        try {
            $apiKey = $this->apiKeyService->getMyKey(
                $request->user()->merchant
            );

            return response()->json([
                'success' => true,
                'message' => 'Merchant API key fetched successfully',
                'data' => $apiKey,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function generate(Request $request)
    {
        try {
            $apiKey = $this->apiKeyService->generate(
                $request->user()->merchant
            );

            return response()->json([
                'success' => true,
                'message' => 'Merchant API key generated successfully',
                'data' => $apiKey,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}