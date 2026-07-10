<?php

namespace App\Exceptions;

use Exception;

class MerchantNotApprovedException extends Exception
{
    protected $message = 'Merchant is not approved yet';
}