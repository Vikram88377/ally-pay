<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MerchantApiKey;
use App\Models\PaymentOrder;
use App\Models\MerchantWebhookSetting;
class Merchant extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'business_email',
        'business_phone',
        'business_type',
        'status',
        'remarks',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function apiKeys()
{
    return $this->hasMany(MerchantApiKey::class);
}

public function paymentOrders()
{
    return $this->hasMany(PaymentOrder::class);
}

public function webhookSetting()
{
    return $this->hasOne(
        MerchantWebhookSetting::class
    );
}
}