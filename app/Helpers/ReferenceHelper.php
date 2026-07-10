<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class ReferenceHelper
{
    public static function generate(string $prefix): string
    {
        return strtoupper($prefix . '-' . Str::random(12));
    }
}