<?php

namespace ArqAdmin\Repositories;


abstract class AbstractRepository
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findAll()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->model->find($id)->update($data);
    }

    public function firstOrCreate(array $data)
    {
        return $this->model->firstOrCreate($data);
    }

    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $model = $this->model;

        if (count($criteria) == 1) {
            foreach ($criteria as $c) {
                $model = $model->where($c[0], $c[1], $c[2]);
            }
        } elseif (count($criteria > 1)) {
            $model = $model->where($criteria[0], $criteria[1], $criteria[2]);
        }

        if (count($orderBy) == 1) {
            foreach ($orderBy as $order) {
                $model = $model->orderBy($order[0], $order[1]);
            }
        } elseif (count($orderBy > 1)) {
            $model = $model->orderBy($orderBy[0], $orderBy[1]);
        }

        if (count($limit)) {
            $model = $model->take((int)$limit);
        }

        if (count($offset)) {
            $model = $model->skip((int)$offset);
        }

        return $model->get();
    }

    public function findOneBy(array $criteria)
    {
        return $this->findBy($criteria)->first();
    }

    // from Doctrine
    public function __call($method, $arguments)
    {
        if (substr($method, 0, 6) == 'findBy') {
            $by = substr($method, 6, strlen($method));
            $method = 'findBy';
        } else {
            if (substr($method, 0, 9) == 'findOneBy') {
                $by = substr($method, 9, strlen($method));
                $method = 'findOneBy';
            } else {
                throw new \Exception(
                    "Undefined method '$method'. The method name must start with " .
                    "either findBy or findOneBy!"
                );
            }
        }
        if (!isset($arguments[0])) {
            // we dont even want to allow null at this point, because we cannot (yet) transform it into IS NULL.
            throw new \Exception('You must have one argument');
        }

        $fieldName = lcfirst($by);

        return $this->$method([$fieldName, '=', $arguments[0]]);
    }

    public function paginate($pages)
    {
        return $this->model->paginate($pages);
    }

}