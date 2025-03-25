<?php

namespace App\Http\Filters;

class ListingFilter extends QueryFilter
{

  protected array $sortable = [];

  public function category($value)
  {
    return $this->builder->where('category_id', $value);
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
