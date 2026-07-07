<?php

namespace App\Services;

use App\Jobs\SendWebhookJob;
use App\Models\WebhookEvent;

class WebhookService
{
    public function dispatchPaymentWebhook($paymentOrder)
    {
        if (!$paymentOrder->callback_url) {
            return null;
        }

        $payload = [
            'event' => 'payment.' . $paymentOrder->status,
            'order_id' => $paymentOrder->order_id,
            'payment_reference' => $paymentOrder->payment_reference,
            'amount' => $paymentOrder->amount,
            'currency' => $paymentOrder->currency,
            'status' => $paymentOrder->status,
            'paid_at' => $paymentOrder->paid_at,
        ];

        $webhookEvent = WebhookEvent::create([
            'payment_order_id' => $paymentOrder->id,
            'event_type' => $payload['event'],
            'callback_url' => $paymentOrder->callback_url,
            'payload' => $payload,
            'status' => 'pending',
        ]);

        SendWebhookJob::dispatch($webhookEvent);

        return $webhookEvent;
    }
}