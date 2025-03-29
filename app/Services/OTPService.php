<?php

namespace App\Services;

use App\Models\User;
use App\Mail\SendOTPEmail;
use Illuminate\Support\Str;
use App\Repositories\OTPRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Exceptions\OTP\InvalidOTPException;
use App\Exceptions\OTP\OTPNotFoundException;
use App\Exceptions\OTP\PhoneAlreadyVerifiedException;

class OTPService extends BaseService
{
    public function __construct(protected OTPRepository $otpRepository, protected UserRepository $userRepository)
    {

    }

    /**
     * @throws PhoneAlreadyVerifiedException
     */
    public function resendOTP(array $payload): bool
    {
        $user = Auth::user();

        if ($user->email_verified_at) {
            throw new PhoneAlreadyVerifiedException();
        }

        $alreadyExistingOTP = $this->otpRepository->whereArray([
            'model_id' => $user->id,
            'model' => User::TAG,
        ]);

        if ($alreadyExistingOTP) {
            $this->otpRepository->delete($alreadyExistingOTP->id);
        }

        return $this->sendOTP([
            'id' => $user->id,
            'model' => User::TAG,
            'email' => $user->email,
        ]);
    }

    public function sendOTP(array $payload): bool
    {
        $otp = strtoupper(Str::random(6));

        $this->otpRepository->create([
            'model_id' => $payload['id'],
            'model' => $payload['model'],
            'otp' => strtolower($otp),
        ]);

        // this should move to a job
        Mail::to($payload['email'])->send(new SendOTPEmail([
            'title' => 'BlueHorn OTP',
            'content' => $otp,
        ]));

        return true;
    }

    /**
     * @throws InvalidOTPException
     * @throws OTPNotFoundException
     */
    public function verifyOTP(array $payload): void
    {
        $otp = $this->otpRepository->findByWhere('otp', strtolower($payload['otp']));

        if (! $otp) {
            throw new OTPNotFoundException();
        }

        if (! $otp->ownedBy(Auth::user()->id)) {
            throw new InvalidOTPException();
        }

        $this->otpRepository->delete($otp->id);

        $this->userRepository->update(Auth::user()->id, [
            'email_verified_at' => now(),
        ]);
    }
}
