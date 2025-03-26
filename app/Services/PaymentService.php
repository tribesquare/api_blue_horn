<?php

namespace App\Services;

use App\Helpers\Paystack;
use App\Mail\PaymentNotice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Repositories\PaymentRepository;
use App\Notifications\PaymentNotification;
use App\Notifications\PaymentSuccessfulNotification;

class PaymentService extends BaseService
{

  public function __construct(
    protected UserService $user,
    protected ListingService $listingService,
    protected PaymentRepository $paymentRepository
  ) {
    parent::__construct($paymentRepository);
  }

  public function checkout($payload)
  {
    $response = Paystack::initiatePayment([
      'amount' => $payload['amount'] * 100,
      'email' => $payload['email'],
    ]);
    if ($response['status']) {
      $this->paymentRepository->create([
        'user_id' => Auth::user()->id,
        'listing_id' => $payload['listing_id'],
        'reference' => $response['data']['reference'],
        'status' => 'pending',
        'amount' => $payload['amount'],
        'currency' => 'NGN',
        'email' => $payload['email'],
        'paystack_init_response' => json_encode($response),
      ]);
    }
    return [
      'url' => $response['data']['authorization_url'],
      'reference' => $response['data']['reference']
    ];
  }

  public function verify($payload)
  {
    $response = Paystack::verifyPayment($payload['reference']);
    if ($response['status']) {
      $payment = $this->paymentRepository->where('reference', $payload['reference']);
      $payment->user->notify(new PaymentSuccessfulNotification($payment));
      // send mail notice to platform user
      Mail::to(config('services.platform.email'))
        ->send(new PaymentNotice($payment));
      $payment->update([
        'status' => $response['data']['status'],
        'paystack_verify_response' => json_encode($response),
        'notification_sent' => true,
      ]);
    }
    return $response;
  }
}
