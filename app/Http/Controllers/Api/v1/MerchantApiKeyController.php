<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\MerchantApiKeyService;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Exception;

class MerchantApiKeyController extends Controller
{
    use ApiResponseTrait;
    public function __construct(
        protected MerchantApiKeyService $apiKeyService
    ) {}

    public function show(Request $request)
    {
        try {
            $apiKey = $this->apiKeyService->getMyKey(
                $request->user()->merchant
            );

            return $this->successResponse(
                $apiKey,
                'Merchant API key generated successfully',
                201
            );

        } catch (Exception $e) {
                return $this->errorResponse(
                    $e->getMessage(),
                    400
                );
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