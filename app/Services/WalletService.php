<?php

namespace App\Services;

use App\Interfaces\WalletRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Exceptions\InsufficientBalanceException;
use App\Exceptions\WalletNotFoundException;
use App\Helpers\ReferenceHelper;
use App\Traits\AuditLogTrait;
class WalletService
{
    use AuditLogTrait;
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
                'reference_id' => ReferenceHelper::generate('CR'),
                'status' => 'success',
            ]);

                $this->logAudit(
                'WALLET_MONEY_ADDED',
                $wallet,
                [
                    'balance' => $wallet->balance - $amount,
                ],
                [
                    'balance' => $wallet->balance,
                    'amount' => $amount,
                ]
            );

            return $wallet;
        });
    }

    public function deductMoney(int $userId, float $amount)
    {
        return DB::transaction(function () use ($userId, $amount) {

            $wallet = $this->walletRepository->lockByUserId($userId);

            if (!$wallet) {
                throw new WalletNotFoundException();
            }

            if ($wallet->balance < $amount) {
            throw new InsufficientBalanceException();
            }

            $wallet->balance -= $amount;
            $wallet->save();

            $this->walletRepository->createTransaction([
                'wallet_id' => $wallet->id,
                'type' => 'debit',
                'amount' => $amount,
                'balance_after' => $wallet->balance,
                'reference_id' => ReferenceHelper::generate('DR'),
                'status' => 'success',
            ]);

                            $this->logAudit(
                    'WALLET_MONEY_DEDUCTED',
                    $wallet,
                    [
                        'balance' => $wallet->balance + $amount,
                    ],
                    [
                        'balance' => $wallet->balance,
                        'amount' => $amount,
                    ]
                );

            return $wallet;
        });
    }



    public function history(int $userId)
{
    return $this->walletRepository->transactions($userId);
}


            public function transferMoney(int $senderId, int $receiverId, float $amount)
{
    if ($senderId === $receiverId) {
        throw new Exception('You cannot transfer money to yourself');
    }

    return DB::transaction(function () use ($senderId, $receiverId, $amount) {

        $senderWallet = $this->walletRepository->lockByUserId($senderId);

        if (!$senderWallet) {
            throw new Exception('Sender wallet not found');
        }

        if ($senderWallet->balance < $amount) {
            throw new Exception('Insufficient wallet balance');
        }

        $receiverWallet = $this->walletRepository->lockByUserId($receiverId);

        if (!$receiverWallet) {
            $receiverWallet = $this->walletRepository->create([
                'user_id' => $receiverId,
                'balance' => 0
            ]);
        }

        $referenceId = ReferenceHelper::generate('TR');

        $senderWallet->balance -= $amount;
        $senderWallet->save();

        $this->walletRepository->createTransaction([
            'wallet_id' => $senderWallet->id,
            'type' => 'debit',
            'amount' => $amount,
            'balance_after' => $senderWallet->balance,
            'reference_id' => $referenceId,
            'status' => 'success',
        ]);

        $receiverWallet->balance += $amount;
        $receiverWallet->save();

        $this->walletRepository->createTransaction([
            'wallet_id' => $receiverWallet->id,
            'type' => 'credit',
            'amount' => $amount,
            'balance_after' => $receiverWallet->balance,
            'reference_id' => $referenceId,
            'status' => 'success',
        ]);

                    $this->logAudit(
                'WALLET_MONEY_TRANSFERRED',
                $senderWallet,
                [],
                [
                    'receiver_wallet_id' => $receiverWallet->id,
                    'amount' => $amount,
                    'reference_id' => $referenceId,
                ]
            );
        return [
            'sender_wallet' => $senderWallet,
            'receiver_wallet' => $receiverWallet,
            'reference_id' => $referenceId,
        ];
    });
}


}