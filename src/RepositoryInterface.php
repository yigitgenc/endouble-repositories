<?php

namespace Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface RepositoryInterface
 *
 * @package Repositories
 */
interface RepositoryInterface
{
    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*']);

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = ['*']);

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = ['*']);

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return object
     */
    public function save(Model $model);

    /**
     * @param array $data
     * @return bool
     */
    public function insert(array $data);

    /**
     * @param array $data
     * @param int $id
     * @param bool $reflect
     * @return bool
     */
    public function update(array $data, $id, $reflect);

    /**
     * @param int $id
     * @param bool $reflect
     * @return bool
     */
    public function delete($id, $reflect);
}
