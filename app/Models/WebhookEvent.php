<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebhookEvent extends Model
{
    protected $fillable = [
        'payment_order_id',
        'event_type',
        'callback_url',
        'payload',
        'status',
        'attempts',
        'response',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function paymentOrder()
    {
        return $this->belongsTo(PaymentOrder::class);
    }
}