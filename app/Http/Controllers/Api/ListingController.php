<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ListingResource;
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
      $listings = $this->listingService->fetchAll($filter);

      return $this->ok('Listings fetched successfully', [
        'data' => ListingResource::collection($listings->items()), // ✅ Transform items
        'pagination' => [
          'total' => $listings->total(),
          'per_page' => $listings->perPage(),
          'current_page' => $listings->currentPage(),
          'last_page' => $listings->lastPage(),
        ],
      ]);
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
      return $this->ok(
        'listing created successfully',
        new ListingResource($this->listingService->createListing($request->validated()))
      );
    } catch (Throwable $th) {
      return $this->error($th->getMessage());
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Request $request)
  {
    try {
      return $this->ok(
        'listing fetched successfully',
        new ListingResource($this->listingService->fetchListing($request->listing))
      );
    } catch (Throwable $th) {
      return $this->error($th->getMessage());
    }
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
