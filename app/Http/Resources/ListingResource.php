<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListingResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->uuid,
      'name' => $this->name,
      'slug' => $this->slug,
      'category_id' => $this->category->slug,
      'description' => $this->description,
      'address' => $this->address,
      'rating' => $this->rating,
      'rooms' => $this->rooms,
      'image_urls' => $this->image_urls,
      'facilities' => $this->facilities,
      'available_from' => $this->available_from,
    ];
  }
}
