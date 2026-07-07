<?php

namespace App\Interfaces;

interface MerchantRepositoryInterface
{
    public function create(array $data);
    public function findByUserId(int $userId);
    public function list();
    public function findById(int $id);
    public function updateStatus(int $id, array $data);
}