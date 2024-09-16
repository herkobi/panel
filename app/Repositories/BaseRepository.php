<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Scopes\GlobalQuery;

abstract class BaseRepository
{
    protected $model;

    public function getAll(): LengthAwarePaginator
    {
        return $this->model::withoutGlobalScope(GlobalQuery::class)->defaultPagination();
    }

    public function getById(string $id, bool $withoutGlobalScope = false): Model
    {
        $query = $withoutGlobalScope
            ? $this->model::withoutGlobalScope(GlobalQuery::class)
            : $this->model::query();

        return $query->findOrFail($id);
    }

    public function create(array $data): Model
    {
        return $this->model::create($data);
    }

    public function update(string $id, array $data): Model
    {
        $model = $this->getById($id);
        $model->update($data);
        return $model;
    }

    public function delete(string $id): void
    {
        $model = $this->getById($id);
        $model->delete();
    }

    public function getUserData(): LengthAwarePaginator
    {
        return $this->model::defaultPagination();
    }
}
