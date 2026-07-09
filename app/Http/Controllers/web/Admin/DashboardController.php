<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Merchant;
use App\Models\PaymentOrder;
use App\Models\WebhookEvent;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_merchants' => Merchant::count(),
            'total_payments' => PaymentOrder::count(),
            'total_webhooks' => WebhookEvent::count(),
        ];

        return view('admin.dashboard.index', compact('stats'));
    }
}