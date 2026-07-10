<?php

namespace App\Helpers;

class MoneyHelper
{
    public static function format($amount): string
    {
        return '₹' . number_format($amount, 2);
    }
}