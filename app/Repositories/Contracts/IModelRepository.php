<?php


namespace App\Repositories\Contracts;


use Illuminate\Database\Eloquent\Model;

interface IModelRepository
{
    const ORDER_BY = 'id';
    const ORDER_DIR = 'DESC';

    public function all();


    public function store($attributes = []);

    public function find($id);

    public function update(Model $model, $attributes = []);

    public function findBy($key, $value);

    public function findAll($fields = [], $applyOrder = true, $orderBy = self::ORDER_BY, $orderDir = self::ORDER_DIR);


}
