<?php

namespace App\Services;

use App\Models\Listing;
use App\Repositories\ListingRepository;

class ListingService extends BaseService
{
  public function __construct(protected ListingRepository $listingRepository)
  {
    parent::__construct($listingRepository);
  }
}