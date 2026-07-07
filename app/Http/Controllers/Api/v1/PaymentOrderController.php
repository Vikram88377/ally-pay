<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\CreatePaymentOrderRequest;
use App\Services\PaymentOrderService;
use App\Http\Requests\Payment\VerifyPaymentRequest;
use Exception;
class PaymentOrderController extends Controller
{
    public function __construct(
        protected PaymentOrderService $paymentOrderService
    ) {}

    public function store(CreatePaymentOrderRequest $request)
    {
        $order = $this->paymentOrderService->createOrder(
            $request->merchant,
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Payment order created successfully',
            'data' => $order,
        ], 201);
    }



    public function verify(VerifyPaymentRequest $request)
{
    try {
        $order = $this->paymentOrderService->verifyPayment(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Payment verified successfully',
            'data' => $order,
        ]);

    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 400);
    }
}
}