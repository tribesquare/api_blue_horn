<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Payment\CheckoutRequest;
use Throwable;
use Illuminate\Http\Request;
use App\Services\PaymentService;

class PaymentController extends ApiController
{
  public function __construct(protected PaymentService $paymentService) {}
  public function checkout(CheckoutRequest $request)
  {
    try {
      return $this->ok(
        'Payment initiated successfully',
        $this->paymentService->checkout($request->validated())
      );
    } catch (Throwable $th) {
      return $this->error($th->getMessage());
    }
  }

  public function verify(Request $request)
  {
    try {
      return $this->ok(
        'Payment verified successfully',
        $this->paymentService->verify(['reference' => $request->ref])
      );
    } catch (Throwable $th) {
      return $this->error($th->getMessage());
    }
  }
}
