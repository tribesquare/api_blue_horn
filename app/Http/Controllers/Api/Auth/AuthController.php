<?php

namespace App\Http\Controllers\API\Auth;

use Throwable;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\API\ApiController;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;

class AuthController extends ApiController
{
  public function __construct(protected UserService $userService) {}

  public function login(LoginRequest $request): JsonResponse
  {
    try {
      $payload = (object) $request->validated();
      $user = $this->userService->loginByEmailCode($payload);

      return $this->ok(
        'User Logged In Successfully',
        new UserResource($user)
      );
    } catch (Throwable $e) {
      return $this->error($e->getMessage());
    }
  }

  public function register(RegistrationRequest $request): JsonResponse
  {
    try {
      $user = $this->userService->register($request->validated());

      return $this->ok('User Created Successfully', new UserResource($user));
    } catch (Throwable $e) {
      return $this->error($e->getMessage());
    }
  }

  public function logout(Request $request): JsonResponse
  {
    $request->user()->token()->revoke();

    return $this->ok('Unauthenticated');
  }

  public function changePassword(ChangePasswordRequest $request): JsonResponse
  {
    if (! Hash::check($request->old_password, Auth::user()->password)) {
      return $this->error('Old password is incorrect');
    }

    try {
      Auth::user()->update([
        'password' => Hash::make($request->password)
      ]);

      return $this->ok('User Password Updated Successfully');
    } catch (Throwable $e) {
      return $this->error($e->getMessage());
    }
  }

  public function user(): JsonResponse
  {
    return $this->ok('User fetched successfully', $this->userService->all());
  }
}
