<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use Exception;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\ApiController;
use Symfony\Component\HttpFoundation\Response;

class PasswordResetController extends ApiController
{
  public function __construct(protected UserService $userService) {}

  public function request(Request $request): JsonResponse
  {
    $request->validate([
      'email' => 'required|exists:users,email',
    ]);

    try {
      $this->userService->passwordResetRequest($request->all());

      return $this->ok('OTP for password reset sent successfully!');
    } catch (Exception $e) {
      return $this->error($e->getMessage(), Response::HTTP_FORBIDDEN);
    }
  }

  public function reset(Request $request): JsonResponse
  {
    try {
      $payload = $request->validate([
        'email' => 'required|exists:users,email',
        'password' => 'required|confirmed',
      ]);
      $this->userService->passwordReset($payload);

      return $this->ok('Password successfully reset. Kindly login with new password!');
    } catch (Exception $e) {
      return $this->error($e->getMessage(), Response::HTTP_FORBIDDEN);
    }
  }
}
