<?php

namespace App\Services;

use App\Interfaces\MerchantApiKeyRepositoryInterface;
use Exception;
use Illuminate\Support\Str;
use App\Exceptions\MerchantNotApprovedException;
use App\Helpers\ReferenceHelper;
use Illuminate\Support\Facades\Hash;

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

            $apiKey = $this->apiKeyRepository
                ->findActiveByMerchantId($merchant->id);

            if (!$apiKey) {
                return null;
            }

            return [
                'id' => $apiKey->id,
                'merchant_id' => $apiKey->merchant_id,
                'public_key' => $apiKey->public_key,
                'is_active' => $apiKey->is_active,
                'created_at' => $apiKey->created_at,
            ];
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

                            $publicKey = 'pk_test_' . Str::random(32);
                            $plainSecretKey = 'sk_test_' . Str::random(40);

                            $apiKey = $this->apiKeyRepository->create([
                                'merchant_id' => $merchant->id,
                                'public_key' => $publicKey,
                                'secret_key' => Hash::make($plainSecretKey),
                                'is_active' => true,
                            ]);

                            return [
                                'id' => $apiKey->id,
                                'merchant_id' => $apiKey->merchant_id,
                                'public_key' => $apiKey->public_key,
                                'secret_key' => $plainSecretKey,
                                'is_active' => $apiKey->is_active,
                                'created_at' => $apiKey->created_at,
                            ];
                        }
}