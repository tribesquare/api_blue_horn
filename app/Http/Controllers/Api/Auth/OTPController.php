<?php

namespace App\Http\Controllers\Api\Auth;

use Throwable;
use App\Services\OTPService;
use Illuminate\Http\JsonResponse;
use App\Exceptions\OTP\InvalidOTPException;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\OTP\ResendOTPRequest;
use App\Http\Requests\OTP\VerifyOTPRequest;
use App\Exceptions\OTP\OTPNotFoundException;
use App\Exceptions\OTP\PhoneAlreadyVerifiedException;

class OTPController extends ApiController
{
    public function __construct(protected OTPService $otpService)
    {

    }

    public function verify(VerifyOTPRequest $request): JsonResponse
    {
        try {
            $this->otpService->verifyOTP($request->validated());

            return $this->ok('OTP verified');
        } catch (InvalidOTPException|OTPNotFoundException $e) {
            return $this->error($e->getMessage(), $e->getCode());
        } catch (Throwable $e) {
            return $this->error($e->getMessage());
        }
    }

    public function resend(ResendOTPRequest $request): JsonResponse
    {
        try {
            $this->otpService->resendOTP($request->validated());

            return $this->ok('OTP sent to user email');
        } catch (PhoneAlreadyVerifiedException $e) {
            return $this->error($e->getMessage(), $e->getCode());
        } catch (Throwable $e) {
            return $this->error($e->getMessage());
        }
    }
}
