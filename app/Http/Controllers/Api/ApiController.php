<?php

namespace App\Http\Controllers\Api;

use App\Traits\General;
use App\Traits\ApiResponses;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
  use ApiResponses, General;

  public function include(string $relationship): bool
  {
    $param = request()->get('include');

    if (!isset($param)) {
      return false;
    }

    $includeValues = explode(',', strtolower($param));

    return in_array(strtolower($relationship), $includeValues);
  }
}
