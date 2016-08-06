<?php

namespace App\Repositories;

use Endouble\Repositories\Repository;

/**
 * Class VacancyRepository
 *
 * @package App\Repositories
 */
class VacancyRepository extends Repository
{
    /**
     * Define your model here.
     *
     * @return string
     */
    protected function model()
    {
        return 'App\Models\Vacancy';
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
