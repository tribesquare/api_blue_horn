<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\Listing;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\ListingService;
use App\Http\Filters\QueryFilter;
use App\Http\Filters\ListingFilter;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Listing\CreateListingRequest;

class ListingController extends ApiController
{

  public function __construct(protected ListingService $listingService) {}
  /**
   * Display a listing of the resource.
   */
  public function index(ListingFilter $filter)
  {
    try {
      return $this->ok(
        'listings fetched successfully',
        $this->listingService->fetchAll($filter)
      );
    } catch (Throwable $th) {
      return $this->error($th->getMessage());
    }
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(CreateListingRequest $request)
  {
    try {
      return $this->ok('listing created successfully', $this->listingService->create($request->validated()));
    } catch (Throwable $th) {
      return $this->error($th->getMessage());
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Listing $listing)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Listing $listing)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Listing $listing)
  {
    //
  }
}
