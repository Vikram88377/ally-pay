<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MerchantApiKey;
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
}