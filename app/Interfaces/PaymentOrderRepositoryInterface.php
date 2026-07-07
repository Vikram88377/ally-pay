<?php

namespace App\Interfaces;

interface PaymentOrderRepositoryInterface
{
    public function create(array $data);
}