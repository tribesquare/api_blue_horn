<?php

namespace App\Models;

use App\Contract\Filterable;
use App\Traits\FilterableScope;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model implements Filterable
{
  use FilterableScope;
  protected $fillable = [
    'name',
    'slug',
    'category_id',
    'description',
    'address',
    'rating',
    'info',
    'image_url',
  ];

  public function category()
  {
    return $this->belongsTo(Category::class, 'category_id');
  }

  protected $casts = [
    'info' => 'object',
  ];
}
