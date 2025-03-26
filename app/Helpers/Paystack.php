<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class Paystack
{
  public static function verifyPayment($ref)
  {
    $response = Http::withHeaders([
      'Authorization' => 'Bearer ' . config('services.paystack.secret_key'),
      'Content-Type' => 'application/json',
    ])->get(
      config('services.paystack.url') . '/transaction/verify/' . $ref
    );
    if ($response->successful()) {
      return $response->json();
    } else {
      return $response->throw(); // or handle the error
    }
  }

  public static function initiatePayment($payload)
  {
    $response = Http::withHeaders([
      'Authorization' => 'Bearer ' . config('services.paystack.secret_key'),
      'Content-Type' => 'application/json',
      'Accept' => 'application/json'
    ])
      ->post(config('services.paystack.url') . '/transaction/initialize', $payload);

    // Check if the request was successful and return response
    if ($response->successful()) {
      return $response->json();
    } else {
      return $response->throw(); // or handle the error
    }
  }
}
