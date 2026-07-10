<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\CreatePaymentOrderRequest;
use App\Services\PaymentOrderService;
use App\Http\Requests\Payment\VerifyPaymentRequest;
use App\Traits\ApiResponseTrait;
use Exception;
class PaymentOrderController extends Controller
{
    use ApiResponseTrait;
    public function __construct(
        protected PaymentOrderService $paymentOrderService
    ) {}

    public function store(CreatePaymentOrderRequest $request)
    {
        $order = $this->paymentOrderService->createOrder(
            $request->merchant,
            $request->validated()
        );

                return $this->successResponse(
                    $order,
                    'Payment order created successfully',
                    201
                );
    }



    public function verify(VerifyPaymentRequest $request)
{
    try {
        $order = $this->paymentOrderService->verifyPayment(
            $request->validated()
        );

                return $this->successResponse(
                    $order,
                    'Payment verified successfully'
                );

    } catch (Exception $e) {
                return $this->errorResponse(
                    $e->getMessage(),
                    400
                );
    }
}
}