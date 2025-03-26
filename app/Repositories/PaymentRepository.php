<?php

namespace App\Repositories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;

class PaymentRepository extends BaseRepository
{
  public function getModelClass(): Model
  {
    return new Payment();
  }
}