<?php

namespace App\Http\Filters;

use Exception;
use App\Models\Category;

class ListingFilter extends QueryFilter
{

  protected array $sortable = [];

  public function category($value)
  {
    $category = Category::where('slug', $value)->first();
    if ($category === null) {
      throw new Exception('Category not found');
    }
    return $this->builder->where('category_id', $category->id);
  }

  public function name($value)
  {
    return $this->builder->where('name', 'like', "%$value%");
  }

  public function destination($value)
  {
    return $this->builder->where('address', 'like', "%$value%");
  }

  public function available_date($value)
  {
    return $this->builder->whereBetween('available_from', explode(',', $value));
  }

  public function rooms($value)
  {
    return $this->builder->where('rooms', '>=', $value);
  }

  public function adults($value)
  {
    return $this->builder->whereJsonContains('rooms', [['adults' => (string) $value]]);
  }

  public function children($value)
  {
    return $this->builder->whereJsonContains('rooms', [['children' => (string) $value]]);
    // return $this->builder->whereRaw("JSON_EXTRACT(rooms, '$[*].children') >= ?", [$value]);
  }
}
