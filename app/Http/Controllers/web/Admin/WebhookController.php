<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebhookEvent;
use App\Jobs\SendWebhookJob;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function index(Request $request)
    {
        $webhooks = WebhookEvent::with('paymentOrder')
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(10);

        return view('admin.webhooks.index', compact('webhooks'));
    }

    public function show(WebhookEvent $webhookEvent)
    {
        $webhookEvent->load('paymentOrder');

        return view('admin.webhooks.show', compact('webhookEvent'));
    }

    public function retry(WebhookEvent $webhookEvent)
    {
        $webhookEvent->update([
            'status' => 'pending',
        ]);

        SendWebhookJob::dispatch($webhookEvent);

        return back()->with('success', 'Webhook retry dispatched successfully');
    }
}