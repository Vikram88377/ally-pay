<?php

namespace App\Repositories;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Interfaces\WalletRepositoryInterface;

class WalletRepository implements WalletRepositoryInterface
{
    public function findByUserId(int $userId)
    {
        return Wallet::where('user_id', $userId)->first();
    }

    public function create(array $data)
    {
        return Wallet::create($data);
    }

    public function lockByUserId(int $userId)
    {
        return Wallet::where('user_id', $userId)
            ->lockForUpdate()
            ->first();
    }

    public function createTransaction(array $data)
    {
        return WalletTransaction::create($data);
    }


    public function transactions(int $userId)
{
    return WalletTransaction::whereHas('wallet', function ($query) use ($userId) {
        $query->where('user_id', $userId);
    })
    ->latest()
    ->paginate(10);
}


        public function lockByWalletId(int $walletId)
{
    return Wallet::where('id', $walletId)
        ->lockForUpdate()
        ->first();
}


}