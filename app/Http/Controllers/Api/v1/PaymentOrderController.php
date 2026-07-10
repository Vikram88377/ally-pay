<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\CreatePaymentOrderRequest;
use App\Http\Requests\Payment\VerifyPaymentRequest;
use App\Models\PaymentOrder;
use App\Services\PaymentOrderService;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Support\Facades\Log;

class PaymentOrderController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected PaymentOrderService $paymentOrderService
    ) {}

    public function store(CreatePaymentOrderRequest $request)
    {
        try {
            $merchant = $request->attributes->get('merchant');

            $order = $this->paymentOrderService->createOrder(
                $merchant,
                $request->validated()
            );

            return $this->successResponse(
                $order,
                'Payment order created successfully',
                201
            );
        } catch (Exception $e) {
            Log::error('Payment order creation failed', [
                'merchant_id' => $request->attributes->get('merchant')?->id,
                'amount' => $request->amount,
                'message' => $e->getMessage(),
                'ip' => $request->ip(),
            ]);

            return $this->errorResponse(
                $e->getMessage(),
                400
            );
        }
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
            Log::warning('Payment verification failed', [
                'order_id' => $request->order_id,
                'payment_reference' => $request->payment_reference,
                'status' => $request->status,
                'message' => $e->getMessage(),
                'ip' => $request->ip(),
            ]);

            return $this->errorResponse(
                $e->getMessage(),
                400
            );
        }
    }

    public function show(PaymentOrder $paymentOrder)
    {
        $this->authorize('view', $paymentOrder);

        $paymentOrder->load([
            'merchant',
            'webhookEvents',
        ]);

        return $this->successResponse(
            $paymentOrder,
            'Payment fetched successfully'
        );
    }
}