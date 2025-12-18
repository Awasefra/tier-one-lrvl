<?php

namespace App\Services\Base;

use Illuminate\Database\Eloquent\Model;

abstract class BaseCrudService
{
    abstract protected function model(): Model;

    public function paginate(int $perPage = 10)
    {
        return $this->model()->newQuery()->paginate($perPage);
    }

    public function get(array $filters = [])
    {
        $query = $this->model()->newQuery();

        foreach ($filters as $field => $value) {
            $query->where($field, $value);
        }

        return $query->get();
    }

    public function create(array $payload): Model
    {
        return $this->model()->create($payload);
    }

    public function find(Model $model): Model
    {
        return $model;
    }

    public function update(Model $model, array $payload): Model
    {
        $model->update($payload);
        return $model;
    }

    public function delete(Model $model): void
    {
        $model->delete();
    }
}
