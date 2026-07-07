<?php

namespace App\Services;

use App\Interfaces\MerchantRepositoryInterface;
use Exception;

class MerchantService
{
    public function __construct(
        protected MerchantRepositoryInterface $merchantRepository
    ) {}

    public function apply(int $userId, array $data)
    {
        $existingMerchant = $this->merchantRepository->findByUserId($userId);

        if ($existingMerchant) {
            throw new Exception('Merchant application already exists');
        }

        $data['user_id'] = $userId;
        $data['status'] = 'pending';

        return $this->merchantRepository->create($data);
    }

    public function myMerchant(int $userId)
    {
        return $this->merchantRepository->findByUserId($userId);
    }

    public function list()
    {
        return $this->merchantRepository->list();
    }

    public function updateStatus(int $merchantId, array $data)
    {
        return $this->merchantRepository->updateStatus($merchantId, $data);
    }
}