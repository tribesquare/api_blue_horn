<?php

namespace App\Models;

use App\Contract\Filterable;
use App\Traits\FilterableScope;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model implements Filterable
{
  use FilterableScope;
  protected $fillable = [
    'uuid',
    'name',
    'slug',
    'category_id',
    'description',
    'address',
    'rating',
    'rooms',
    'image_urls',
    'facilities',
    'available_from',
  ];

  public function category()
  {
    return $this->belongsTo(Category::class, 'category_id');
  }

  public function payments()
  {
    return $this->hasMany(Payment::class);
  }

  protected $casts = [
    'rooms' => 'object',
    'image_urls' => 'object',
    'facilities' => 'object',
  ];
}
