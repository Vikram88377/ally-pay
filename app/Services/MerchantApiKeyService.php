<?php

namespace App\Services;

use App\Interfaces\MerchantApiKeyRepositoryInterface;
use Exception;
use Illuminate\Support\Str;
use App\Exceptions\MerchantNotApprovedException;
use App\Helpers\ReferenceHelper;


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
            throw new MerchantNotApprovedException();
        }

        return $this->apiKeyRepository->findActiveByMerchantId($merchant->id);
    }

    public function generate($merchant)
    {
        if (!$merchant) {
            throw new Exception('Merchant profile not found');
        }

        if ($merchant->status !== 'approved') {
           throw new MerchantNotApprovedException();
        }

        $this->apiKeyRepository->deactivateOldKeys($merchant->id);

        return $this->apiKeyRepository->create([
            'merchant_id' => $merchant->id,
            'public_key' => strtolower(ReferenceHelper::generate('PK_TEST')),
            'secret_key' => strtolower(ReferenceHelper::generate('SK_TEST')),
            'is_active' => true,
        ]);
    }
}