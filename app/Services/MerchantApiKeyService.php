<?php

namespace App\Services;

use App\Interfaces\MerchantApiKeyRepositoryInterface;
use Exception;
use Illuminate\Support\Str;

class MerchantApiKeyService
{
    public function __construct(
        protected MerchantApiKeyRepositoryInterface $apiKeyRepository
    ) {}

    public function getMyKey($merchant)
    {
        if (!$merchant) {
            throw new Exception('Merchant profile not found');
        }

        if ($merchant->status !== 'approved') {
            throw new Exception('Merchant is not approved yet');
        }

        return $this->apiKeyRepository->findActiveByMerchantId($merchant->id);
    }

    public function generate($merchant)
    {
        if (!$merchant) {
            throw new Exception('Merchant profile not found');
        }

        if ($merchant->status !== 'approved') {
            throw new Exception('Merchant is not approved yet');
        }

        $this->apiKeyRepository->deactivateOldKeys($merchant->id);

        return $this->apiKeyRepository->create([
            'merchant_id' => $merchant->id,
            'public_key' => 'pk_test_' . Str::random(32),
            'secret_key' => 'sk_test_' . Str::random(40),
            'is_active' => true,
        ]);
    }
}