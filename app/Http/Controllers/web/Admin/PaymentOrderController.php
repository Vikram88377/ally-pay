<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentOrder;
use Illuminate\Http\Request;

class PaymentOrderController extends Controller
{
    public function index(Request $request)
    {
        $payments = PaymentOrder::with('merchant')
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(10);

        return view('admin.payments.index', compact('payments'));
    }

    public function show(PaymentOrder $paymentOrder)
    {
        $paymentOrder->load('merchant', 'webhookEvents');

        return view('admin.payments.show', compact('paymentOrder'));
    }
}