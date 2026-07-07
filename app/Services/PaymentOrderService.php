<?php

namespace App\Services;

use App\Interfaces\PaymentOrderRepositoryInterface;
use Illuminate\Support\Str;

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
}