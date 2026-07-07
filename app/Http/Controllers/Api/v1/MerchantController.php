<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\CreateMerchantRequest;
use App\Services\MerchantService;
use Illuminate\Http\Request;
use Exception;

class MerchantController extends Controller
{
    public function __construct(
        protected MerchantService $merchantService
    ) {}

    public function apply(CreateMerchantRequest $request)
    {
        try {
            $merchant = $this->merchantService->apply(
                $request->user()->id,
                $request->validated()
            );

            return response()->json([
                'success' => true,
                'message' => 'Merchant application submitted successfully',
                'data' => $merchant,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function myMerchant(Request $request)
    {
        $merchant = $this->merchantService->myMerchant($request->user()->id);

        return response()->json([
            'success' => true,
            'message' => 'Merchant profile fetched successfully',
            'data' => $merchant,
        ]);
    }
}