<?php

namespace App\Http\Controllers\Web\Merchant;

use App\Http\Controllers\Controller;
use App\Models\PaymentOrder;
use Illuminate\Http\Request;

class PaymentOrderController extends Controller
{
    public function index(Request $request)
    {
        $merchant = $request->user()->merchant;

        $payments = PaymentOrder::query()
            ->where('merchant_id', $merchant->id)
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('merchant.payments.index', compact('payments'));
    }

    public function show(Request $request, PaymentOrder $paymentOrder)
    {
        $merchant = $request->user()->merchant;

        abort_unless(
            $paymentOrder->merchant_id === $merchant->id,
            403
        );

        $paymentOrder->load('webhookEvents');

        return view(
            'merchant.payments.show',
            compact('paymentOrder')
        );
    }
}