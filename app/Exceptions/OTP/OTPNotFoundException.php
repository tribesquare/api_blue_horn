<?php

namespace App\Exceptions\OTP;

use Exception;
use Illuminate\Http\Response;

class OTPNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('OTP not found', Response::HTTP_NOT_FOUND);
    }
}
