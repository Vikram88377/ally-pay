<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WebhookEvent;
class PaymentOrder extends Model
{
    protected $fillable = [
        'merchant_id',
        'order_id',
        'amount',
        'currency',
        'status',
        'customer_name',
        'customer_email',
        'customer_phone',
        'callback_url',
        'metadata',
        'payment_reference',
        'paid_at',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function webhookEvents()
{
    return $this->hasMany(WebhookEvent::class);
}
}