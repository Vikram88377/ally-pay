<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\UpdateMerchantStatusRequest;
use App\Services\MerchantService;

class MerchantController extends Controller
{
    public function __construct(
        protected MerchantService $merchantService
    ) {}

    public function index()
    {
        $merchants = $this->merchantService->list();

        return response()->json([
            'success' => true,
            'message' => 'Merchants fetched successfully',
            'data' => $merchants,
        ]);
    }

    public function updateStatus(UpdateMerchantStatusRequest $request, int $id)
    {
        $merchant = $this->merchantService->updateStatus(
            $id,
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Merchant status updated successfully',
            'data' => $merchant,
        ]);
    }
}