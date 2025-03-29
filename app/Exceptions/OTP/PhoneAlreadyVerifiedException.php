<?php

namespace App\Exceptions\OTP;

use Exception;
use Illuminate\Http\Response;

class PhoneAlreadyVerifiedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Email already verified', Response::HTTP_CONFLICT);
    }
}
