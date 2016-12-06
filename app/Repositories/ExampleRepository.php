<?php

namespace App\Repositories;

use Endouble\Repositories\Repository;

/**
 * Class ExampleRepository
 *
 * @package App\Repositories
 */
class ExampleRepository extends Repository
{
    /**
     * Define your model here.
     *
     * @return string
     */
    protected function model()
    {
        return 'App\Models\Example';
    }

    /**
     * Search results in content by giving a string.
     *
     * @param $string
     * @return mixed
     */
    public function searchInContent($string)
    {
        return $this->model->where('content', 'like', "%{$string}%")->get();
    }
}
