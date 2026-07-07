<?php

namespace App\Services;

use App\Interfaces\PaymentOrderRepositoryInterface;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\DB;

class PaymentOrderService
{
    public function __construct(
        protected PaymentOrderRepositoryInterface $paymentOrderRepository
    ) {}

    public function createOrder($merchant, array $data)
    {
        $data['merchant_id'] = $merchant->id;
        $data['order_id'] = 'ORD-' . strtoupper(Str::random(12));
        $data['currency'] = $data['currency'] ?? 'INR';
        $data['status'] = 'pending';

        return $this->paymentOrderRepository->create($data);
    }


    public function verifyPayment(array $data)
{
    return DB::transaction(function () use ($data) {

        $order = $this->paymentOrderRepository->findByOrderId(
            $data['order_id']
        );

        if ($order->status !== 'pending') {
            throw new Exception('Payment order already processed');
        }

        $order->update([
            'status' => $data['status'],
            'payment_reference' => $data['payment_reference'],
            'paid_at' => $data['status'] === 'success' ? now() : null,
        ]);

        return $order;
    });
}
}