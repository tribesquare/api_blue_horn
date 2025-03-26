<?php

namespace App\Http\Filters;

use App\Models\Category;

class ListingFilter extends QueryFilter
{

  protected array $sortable = [];

  public function category($value)
  {
    $category = Category::where('slug', $value)->first();
    return $this->builder->where('category_id', $category->id);
  }

  public function name($value)
  {
    return $this->builder->where('name', 'like', "%$value%");
  }

  public function address($value)
  {
    return $this->builder->where('address', 'like', "%$value%");
  }
}
