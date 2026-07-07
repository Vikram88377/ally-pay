<?php

namespace App\Services;

use App\Interfaces\WalletRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class WalletService
{
    public function __construct(
        protected WalletRepositoryInterface $walletRepository
    ) {}

    public function createWallet(int $userId)
    {
        $wallet = $this->walletRepository->findByUserId($userId);

        if ($wallet) {
            return $wallet;
        }

        return $this->walletRepository->create([
            'user_id' => $userId,
            'balance' => 0
        ]);
    }

    public function getBalance(int $userId)
    {
        return $this->createWallet($userId);
    }

    public function addMoney(int $userId, float $amount)
    {
        return DB::transaction(function () use ($userId, $amount) {

            $wallet = $this->walletRepository->lockByUserId($userId);

            if (!$wallet) {
                $wallet = $this->walletRepository->create([
                    'user_id' => $userId,
                    'balance' => 0
                ]);
            }

            $wallet->balance += $amount;
            $wallet->save();

            $this->walletRepository->createTransaction([
                'wallet_id' => $wallet->id,
                'type' => 'credit',
                'amount' => $amount,
                'balance_after' => $wallet->balance,
                'reference_id' => 'CR-' . time(),
                'status' => 'success',
            ]);

            return $wallet;
        });
    }

    public function deductMoney(int $userId, float $amount)
    {
        return DB::transaction(function () use ($userId, $amount) {

            $wallet = $this->walletRepository->lockByUserId($userId);

            if (!$wallet) {
                throw new Exception('Wallet not found');
            }

            if ($wallet->balance < $amount) {
                throw new Exception('Insufficient wallet balance');
            }

            $wallet->balance -= $amount;
            $wallet->save();

            $this->walletRepository->createTransaction([
                'wallet_id' => $wallet->id,
                'type' => 'debit',
                'amount' => $amount,
                'balance_after' => $wallet->balance,
                'reference_id' => 'DR-' . time(),
                'status' => 'success',
            ]);

            return $wallet;
        });
    }



    public function history(int $userId)
{
    return $this->walletRepository->transactions($userId);
}
}