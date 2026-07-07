<?php

namespace App\Repositories;

use App\Models\Merchant;
use App\Interfaces\MerchantRepositoryInterface;

class MerchantRepository implements MerchantRepositoryInterface
{
    public function create(array $data)
    {
        return Merchant::create($data);
    }

    public function findByUserId(int $userId)
    {
        return Merchant::where('user_id', $userId)->first();
    }

    public function list()
    {
        return Merchant::with('user')->latest()->paginate(10);
    }

    public function findById(int $id)
    {
        return Merchant::findOrFail($id);
    }

    public function updateStatus(int $id, array $data)
    {
        $merchant = $this->findById($id);
        $merchant->update($data);

        return $merchant;
    }
}