<?php

namespace App\Interfaces;

interface MerchantApiKeyRepositoryInterface
{
    public function create(array $data);
    public function findActiveByMerchantId(int $merchantId);
    public function deactivateOldKeys(int $merchantId);
}