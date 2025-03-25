<?php

namespace App\Models;

use App\Contract\Filterable;
use App\Traits\FilterableScope;
use Illuminate\Database\Eloquent\Model;

class Category extends Model implements Filterable
{
  use FilterableScope;
    protected $fillable = ['name', 'slug', 'is_active'];

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }
}
