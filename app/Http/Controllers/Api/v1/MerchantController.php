<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\CreateMerchantRequest;
use App\Services\MerchantService;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Exception;

class MerchantController extends Controller
{
    use ApiResponseTrait;
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

                return $this->successResponse(
                    $merchant,
                    'Merchant application submitted successfully',
                    201
                );

        } catch (Exception $e) {
                return $this->errorResponse(
                    $e->getMessage(),
                    400
                );
        }
    }

    public function myMerchant(Request $request)
    {
        $merchant = $this->merchantService->myMerchant($request->user()->id);

                return $this->successResponse(
                    $merchant,
                    'Merchant profile fetched successfully'
                );
    }
}