<?php

namespace Endouble\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Abstract Class Repository
 *
 * @package Endouble\Repositories
 */
abstract class Repository implements RepositoryInterface
{
    /**
     * @var $model
     */
    protected $model;

    /**
     * @var array $sources
     */
    private $sources = [];

    /**
     * @var string $source;
     */
    private $source;

    /**
     * Define Model class name.
     * Must be implemented in the repository class.
     *
     * @return mixed
     */
    abstract protected function model();

    /**
     * @inheritdoc
     */
    public function all($columns = ['*'])
    {
        return $this->model->get($columns);
    }

    /**
     * @inheritdoc
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * @inheritdoc
     */
    public function findBy($field, $value, $columns = ['*'])
    {
        return $this->model->where($field, $value)->get($columns);
    }

    /**
     * @inheritdoc
     */
    public function paginate($perPage = 15, $columns = ['*'])
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @inheritdoc
     */
    public function save(Model $model)
    {
        $model->setConnection($this->source);
        $model->save();

        return (object) $model->getAttributes();
    }

    /**
     * @inheritdoc
     */
    public function insert(array $data)
    {
        return $this->model->insert($data);
    }

    /**
     * @inheritdoc
     */
    public function update(array $data, $id, $reflect = false)
    {
        if ($reflect) {
            $currentSource = $this->source;

            foreach ($this->sources as $source) {
                $this->setSource($source);
                $this->model->findOrFail($id)->update($data);
            }

            // Set changed connection during reflection with previous one.
            $this->setSource($currentSource);

            return true;
        }

        return $this->model->findOrFail($id)->update($data);
    }

    /**
     * @inheritdoc
     */
    public function delete($id, $reflect = false)
    {
        if ($reflect) {
            $currentSource = $this->source;

            foreach ($this->sources as $source) {
                $this->setSource($source);
                $this->model->findOrFail($id)->delete();
            }

            // Set changed connection during reflection with previous one.
            $this->setSource($currentSource);

            return true;
        }

        return $this->model->findOrFail($id)->delete();
    }

    /**
     * Creates new class from the model method,
     * throws `RepositoryException` if it is not an instance of
     * `\Illuminate\Database\Eloquent\Model`
     *
     *
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Endouble\Repositories\RepositoryException
     */
    private function setModel()
    {
        $model = $this->model();
        $model = new $model();

        $model->setConnection($this->source);

        try {
            if ( !$model instanceof Model) {
                throw new RepositoryException("{$this->model()} class must be a instance of 
                Illuminate\\Database\\Eloquent\\Model");
            }
        } catch (RepositoryException $e) {
            die($e->getMessage() . PHP_EOL);
        }

        return $this->model = $model->newQuery();
    }

    /**
     * @param $source
     * @return Repository
     *
     * @throws \Endouble\Repositories\RepositoryException
     */
    public function addSource($source)
    {
        try {
            if (!in_array($source, $this->sources) && $source != 'default') {
                $this->sources[] = $source;
            } else {
                throw new RepositoryException("{$source} already exists!");
            }
        } catch (RepositoryException $e) {
            die($e->getMessage() . PHP_EOL);
        }

        return $this;
    }

    /**
     * @param $source
     * @return Repository
     *
     * @throws \Endouble\Repositories\RepositoryException
     */
    public function removeSource($source)
    {
        try {
            if ($this->source == $source) {
                throw new RepositoryException("You cannot remove the selected source!");
            } else if (in_array($source, $this->sources)) {
                $this->sources[$source] = null;
            } else {
                throw new RepositoryException("{$source} not found!");
            }
        } catch (RepositoryException $e) {
            die($e->getMessage() . PHP_EOL);
        }

        return $this;
    }

    /**
     * @param $source
     * @return null
     *
     * @throws \Endouble\Repositories\RepositoryException
     */
    public function setSource($source)
    {
        try {
            if (in_array($source, $this->sources)) {
                $this->source = $source;
                $this->setModel();
            } else {
                throw new RepositoryException("{$source} not found!");
            }
        } catch (RepositoryException $e) {
            die($e->getMessage() . PHP_EOL);
        }
    }

    /**
     * @return array
     */
    public function getSources()
    {
        return $this->sources;
    }
}
