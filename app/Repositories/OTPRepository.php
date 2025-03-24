<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\OTP;
use Illuminate\Database\Eloquent\Model;

class OTPRepository extends BaseRepository
{
    public function getModelClass(): Model
    {
        return new OTP();
    }
}
