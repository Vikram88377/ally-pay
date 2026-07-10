<?php

namespace App\Http\Controllers\Web\Merchant;

use App\Http\Controllers\Controller;
use App\Models\PaymentOrder;
use App\Models\WebhookEvent;

class DashboardController extends Controller
{
    public function index()
    {
        $merchant = auth()->user()->merchant;

        $stats = [
            'total_payments' => PaymentOrder::where(
                'merchant_id',
                $merchant->id
            )->count(),

            'successful_payments' => PaymentOrder::where(
                'merchant_id',
                $merchant->id
            )
                ->where('status', 'success')
                ->count(),

            'failed_payments' => PaymentOrder::where(
                'merchant_id',
                $merchant->id
            )
                ->where('status', 'failed')
                ->count(),

            'total_revenue' => PaymentOrder::where(
                'merchant_id',
                $merchant->id
            )
                ->where('status', 'success')
                ->sum('amount'),

            'webhook_events' => WebhookEvent::whereHas(
                'paymentOrder',
                function ($query) use ($merchant) {
                    $query->where(
                        'merchant_id',
                        $merchant->id
                    );
                }
            )->count(),
        ];

        $recentPayments = PaymentOrder::where(
            'merchant_id',
            $merchant->id
        )
            ->latest()
            ->limit(5)
            ->get();

        return view(
            'merchant.dashboard.index',
            compact(
                'merchant',
                'stats',
                'recentPayments'
            )
        );
    }
}