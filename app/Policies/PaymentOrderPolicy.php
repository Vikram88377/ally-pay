<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PaymentOrder;

class PaymentOrderPolicy
{
    public function view(
        User $user,
        PaymentOrder $paymentOrder
    ): bool {

        // Admin can access everything

        if ($user->hasRole('admin')) {
            return true;
        }


        // Merchant only own payment

        return $user->merchant
            &&
            $user->merchant->id === $paymentOrder->merchant_id;
    }
}