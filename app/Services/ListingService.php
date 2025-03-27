<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Str;
use App\Repositories\ListingRepository;
use Illuminate\Database\Eloquent\Model;

class ListingService extends BaseService
{
  public function __construct(protected ListingRepository $listingRepository)
  {
    parent::__construct($listingRepository);
  }
  public function createListing(array $data): Model
  {
    $data['slug'] = Str::slug($data['name'], '_');
    $data['uuid'] = Str::uuid();
    return $this->repository->create($data);
  }

  public function fetchListing($listing)
  {
    // dd($listing);
    $listing = $this->repository->where('uuid', $listing);
    if ($listing == null) {
      throw new Exception('Listing not found');
    }
    return $listing;
  }
}
