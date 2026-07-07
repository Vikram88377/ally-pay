<?php

namespace App\Repositories;

use App\Models\MerchantApiKey;
use App\Interfaces\MerchantApiKeyRepositoryInterface;

class MerchantApiKeyRepository implements MerchantApiKeyRepositoryInterface
{
    public function create(array $data)
    {
        return MerchantApiKey::create($data);
    }

    public function findActiveByMerchantId(int $merchantId)
    {
        return MerchantApiKey::where('merchant_id', $merchantId)
            ->where('is_active', true)
            ->latest()
            ->first();
    }

    public function deactivateOldKeys(int $merchantId)
    {
        return MerchantApiKey::where('merchant_id', $merchantId)
            ->update(['is_active' => false]);
    }
}