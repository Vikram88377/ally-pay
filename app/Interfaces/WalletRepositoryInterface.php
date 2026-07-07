<?php

namespace App\Interfaces;

interface WalletRepositoryInterface
{
    public function findByUserId(int $userId);
    public function create(array $data);
    public function lockByUserId(int $userId);
    public function createTransaction(array $data);
    public function transactions(int $userId);
}