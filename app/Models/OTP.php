<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'otp',
        'model',
    ];

    public function ownedBy(int $userId): bool
    {
        return $this->model_id === $userId;
    }
}
