<?php

namespace App\Services;

use App\Mail\SendOTPEmail;
use Exception;
use Throwable;
use App\Models\User;
use App\Services\OTPService;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class UserService extends BaseService
{
  public function __construct(
    protected UserRepository $userRepository,
    protected OTPService $OTPService
  ) {}

  public function register($payload): Model
  {
    try {
      DB::beginTransaction();

      $user = $this->userRepository->create([
        'email' => $payload['email'],
        'password' => Hash::make($payload['password']),
        'name' => $payload['name'],
      ]);

      //move this to a job
      if (isset($payload['email'])) {
        $this->OTPService->sendOTP([
          'id' => $user->id,
          'model' => User::TAG,
          'email' => $user->email,
        ]);
      }

      $user->token = $user->createToken(User::TOKEN_NAME)->plainTextToken;

      DB::commit();

      return $user;
    } catch (Throwable $e) {
      DB::rollBack();

      throw $e;
    }
  }

  public function passwordResetRequest(array $payload): void
  {
    $user = $this->userRepository->where('email', $payload['email'])->first();

    $this->OTPService->sendOTP([
      'id' => $user->id,
      'model' => User::TAG,
      'email' => $user->email,
    ]);
  }

  public function passwordReset(array $payload): bool
  {
    $user = $this->userRepository->where('email', $payload['email']);

    $user->update([
      'password' => Hash::make($payload['password'])
    ]);

    return true;
  }

  /**
   * @throws Exception
   */
  public function loginByEmailCode($payload): Model|array
  {
    if (!$this->cantAttemptAuth($payload)) {
      throw new Exception('Records provided does not match with our record.');
    }

    $user = $this->getUserByIdentifier($payload->identifier);
    if ($user->email_verified_at === null) {
      $this->OTPService->sendOTP([
        'id' => $user->id,
        'model' => User::TAG,
        'email' => $user->email,
      ]);
      $user->token = $user->createToken(
        User::TOKEN_NAME
      )->plainTextToken;

      return [
        'token' => $user->token,
        'message' => 'User is not verified, please verify first. Using the Verify OTP endpoint.'
      ];
    }
    $user->token = $user->createToken(
      User::TOKEN_NAME
    )->plainTextToken;

    return $user;
  }

  private function cantAttemptAuth($payload): bool
  {
    return Auth::attempt(['email' => $payload->identifier, 'password' => $payload->password]);
  }

  private function getUserByIdentifier(?string $identifier): ?User
  {
    return $this->userRepository->findByWhere('email', $identifier);
  }

  public function all(): Collection
  {
    return $this->userRepository->all();
  }

  public function paginate($paginationCount)
  {
    return $this->userRepository->paginate($paginationCount);
  }

  public function update(int $id, array $payload): Model
  {
    return $this->userRepository->update($id, $payload);
  }
}
