<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantApiKey extends Model
{
    protected $fillable = [
        'merchant_id',
        'public_key',
        'secret_key',
        'is_active',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

        protected $hidden = [
    'secret_key',
];

}