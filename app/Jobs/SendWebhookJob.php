<?php

namespace App\Jobs;

use App\Models\WebhookEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class SendWebhookJob implements ShouldQueue
{
    use Queueable;

    public $tries = 3;

    public function __construct(
        public WebhookEvent $webhookEvent
    ) {}

    public function handle(): void
    {
        $this->webhookEvent->increment('attempts');

        try {
            $response = Http::post(
                $this->webhookEvent->callback_url,
                $this->webhookEvent->payload
            );

            $this->webhookEvent->update([
                'status' => $response->successful() ? 'success' : 'failed',
                'response' => $response->body(),
            ]);

        } catch (\Exception $e) {
            $this->webhookEvent->update([
                'status' => 'failed',
                'response' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}