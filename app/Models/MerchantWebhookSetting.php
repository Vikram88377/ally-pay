<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantWebhookSetting extends Model
{
    protected $fillable = [
        'merchant_id',
        'callback_url',
        'secret_key',
        'is_active',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}