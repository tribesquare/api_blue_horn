<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ListingController;
use App\Http\Controllers\Api\Auth\OTPController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\PasswordResetController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::post('password/reset', [PasswordResetController::class, 'reset']);
Route::post('password/reset/request', [PasswordResetController::class, 'request']);

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);
Route::apiResource('listings', ListingController::class);

Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
  Route::post('/password/change', [AuthController::class, 'changePassword'])->name('auth.password.change');

  Route::post('/verify-otp', [OTPController::class, 'verify'])->name('otp.verify');
  Route::get('resend-otp', [OTPController::class, 'resend'])->name('otp.verify');
});
