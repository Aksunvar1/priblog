<?php

namespace App\Repositories\BaseRepository;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Throwable;

interface RepositoryContract
{
    /**
     * Get all items
     *
     * @param  string  $columns specific columns to select
     * @param  string  $orderBy column to sort by
     * @param  string  $sort sort direction
     */
    public function getAll($columns = null, $orderBy = null, $sort = null);

    public function getQuery(): Builder;

    /**
     * Get all items
     *
     * @param  string  $columns specific columns to select
     * @param  string  $secondOrderBy column to sort by
     * @param  string  $orderBy second column to sort by
     * @param  string  $sort sort direction
     */
    public function getAllWithDoubleOrderBy($columns = null, $secondOrderBy = null, $orderBy = null, $sort = null);

    public function count();

    /**
     * Get paged items
     *
     * @param  int  $paged Items per page
     * @param  string  $orderBy Column to sort by
     * @param  string  $sort Sort direction
     */
    public function getPaginated($paged = 15, $orderBy = null, $sort = null);

    /**
     * Get paged items
     *
     * @param  int  $paged Items per page
     * @param  string  $secondOrderBy Column to sort by
     * @param  string  $orderBy Column to sort by
     * @param  string  $sort Sort direction
     */
    public function getPaginatedWithDoubleOrderBy($paged = 15, $secondOrderBy = null, $orderBy = null, $sort = null);

    /**
     * Items for select options
     *
     * @param  string  $data column to display in the option
     * @param  string  $key column to be used as the value in option
     * @param  string  $orderBy column to sort by
     * @param  string  $sort sort direction
     * @return array  array with key value pairs
     */
    public function getForSelect(string $data, $key = 'id', $orderBy = null, $sort = null): array;

    /**
     * Get item by its id
     */
    public function getById(int $modelId);

    public function getManyById(array $modelIds);

    public function getByUuid(string $modelUuid): ?Model;

    public function findByUuidWith(string $uuid, array $with): ?Model;

    /**
     * Get instance of model by column
     *
     * @param  mixed  $term search term
     * @param  string  $column column to search
     */
    public function getItemByColumn($term, $column = 'slug');

    /**
     * Get instance of model by column
     *
     * @param  mixed  $term search term
     * @param  string  $column column to search
     */
    public function getCollectionByColumn($term, $column = 'slug');

    /**
     * Get item by id or column
     *
     * @param  mixed  $term id or term
     * @param  string  $column column to search
     */
    public function getActively($term, $column = 'slug');

    /**
     * Create new using mass assignment
     */
    public function create(array $data): ?Model;

    /**
     * This methods add new item for the has many relation
     *
     * @param  HasMany|HasOne  $relation
     */
    public function createChild($relation, array $data): ?Model;

    public function createChildren(HasMany $relation, array $data): Collection;

    /**
     * Update or crate a record and return the entity
     */
    public function updateOrCreate(array $attributes, array $values = []): ?Model;

    /**
     * @param  HasMany|HasOne  $relation
     */
    public function updateOrCreateForChild($relation, array $attributes, array $values = []): ?Model;

    /**
     * @return mixed
     */
    public function firstOrCreate(array $attributes, array $values = []);

    /**
     * Delete a record by it's ID.
     */
    public function deleteMass($modelId): bool;

    /**
     * Delete a record by its model
     */
    public function delete(Model $model): ?bool;

    public function restore(Model $model): ?bool;

    public function forceDelete(Model $model): ?bool;

    /**
     * @return mixed
     */
    public function update(Model $model, array $data): ?Model;

    public function updateMass($modelId, array $data): bool;

    public function withTrashed(): BaseEloquentRepository;

    public function onlyTrashed(): BaseEloquentRepository;

    public function withFilters($filter): BaseEloquentRepository;

    public function with($relationships): BaseEloquentRepository;

    public function parseRequest(array $requestArray): void;

    /**
     * @throws Throwable
     */
    public function beginTransaction();

    /**
     * @throws Throwable
     */
    public function rollback();

    /**
     * @throws Throwable
     */
    public function commit();

    /**
     * @throws Throwable
     */
    public function transaction(Closure $closure);

    public function findByAttributes(array $attributes): ?Model;
}
