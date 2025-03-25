<?php

namespace App\Repositories;

use App\Models\Listing;
use Illuminate\Database\Eloquent\Model;

class ListingRepository extends BaseRepository
{
  public function getModelClass(): Model
  {
    return new Listing();
  }
}