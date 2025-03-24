<?php

namespace App\Exceptions\OTP;

use Exception;
use Illuminate\Http\Response;

class InvalidOTPException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid OTP or unauthorized access.', Response::HTTP_FORBIDDEN);
    }
}
