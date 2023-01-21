<?php


namespace App\Repositories\SQL;

use App\Repositories\Contracts\IModelRepository;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractModelRepository implements IModelRepository
{
    public Model $model;


    /**
     * AbstractModelRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function store($attributes = [])
    {
        if (!empty($attributes))
            return $this->model->create($attributes);
        else
            return false;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update(Model $model, $attributes = [])
    {
        if (!empty($attributes)) {
            $model->update($attributes);
            return $model;
        }
        return $model;
    }


    public function findBy($key, $value)
    {
        return $this->model->where($key, $value)->first();
    }

    public function findAll($fields = ['*'], $applyOrder = true, $orderBy = self::ORDER_BY, $orderDir = self::ORDER_DIR)
    {
        $query = $this->model;
        if ($applyOrder) {
            $query = $query->orderBy($orderBy, $orderDir);
        }
        return $query->get($fields);
    }
}
