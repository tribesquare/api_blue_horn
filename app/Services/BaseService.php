<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Http\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
  public function __construct(protected $repository) {}
  public function create(array $data): Model
  {
    $data['slug'] = Str::slug($data['name'], '_');
    return $this->repository->create($data);
  }

  public function update(int $id, array $data)
  {
    return $this->repository->update($id, $data);
  }

  /**
   * @throws \Exception
   */
  public function fetchAll(QueryFilter $filter, array $with = [])
  {
    return $this->repository->getAllWithFilters($filter, $with);
  }

  public function paginate($number)
  {
    return $this->repository->paginate($number);
  }

  public function find($payload)
  {
    return $this->repository->find($payload);
  }
}
