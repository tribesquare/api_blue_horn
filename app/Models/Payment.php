<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
  protected $fillable = [
    'user_id',
    'listing_id',
    'reference',
    'status',
    'amount',
    'currency',
    'email',
    'paystack_init_response',
    'paystack_verify_response',
    'notification_sent'
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function listing(): BelongsTo
  {
    return $this->belongsTo(Listing::class);
  }
}
