<?php

namespace App\Http\Services;

use Illuminate\Database\Eloquent\{Model,Collection};
use Illuminate\Pagination\LengthAwarePaginator;

abstract class Service
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Find a record by its ID
     *
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Create a new record
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update an existing record
     *
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function update(int $id, array $data): ?Model
    {
        $record = $this->find($id);
        if ($record) {
            $record->update($data);
            return $record;
        }
        return null;
    }

    /**
     * Delete a record
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $record = $this->find($id);
        if ($record) {
            return $record->delete();
        }
        return false;
    }

    /**
     * Get paginated results
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    /**
     * Get records with specific conditions
     *
     * @param array $conditions
     * @return Collection
     */
    public function where(array $conditions): Collection
    {
        return $this->model->where($conditions)->get();
    }

    /**
     * Get the first record matching the conditions
     *
     * @param array $conditions
     * @return Model|null
     */
    public function firstWhere(array $conditions): ?Model
    {
        return $this->model->where($conditions)->first();
    }

    /**
     * Get records with relationships loaded
     *
     * @param array $relations
     * @return Collection
     */
    public function with(array $relations): Collection
    {
        return $this->model->with($relations)->get();
    }

    /**
     * Count the number of records
     *
     * @return int
     */
    public function count(): int
    {
        return $this->model->count();
    }
}
