<?php

namespace App\Repositories;

use App\Models\PaymentOrder;
use App\Interfaces\PaymentOrderRepositoryInterface;

class PaymentOrderRepository implements PaymentOrderRepositoryInterface
{
    public function create(array $data)
    {
        return PaymentOrder::create($data);
    }
}