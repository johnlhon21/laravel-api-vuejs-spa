<?php
/**
 * Created by PhpStorm.
 * User: Marlon.Bagayawa
 * Date: 6/24/2018
 * Time: 6:06 AM
 */

namespace App\Repositories;


use App\Repositories\Contracts\RepositoryContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

abstract class AbstractRepository implements RepositoryContract
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById(int $id)
    {
        return $this->model->findOrfail($id);
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update(int $id, array $attributes)
    {
        return $this->model->findOrfail($id)->update($attributes);
    }

    public function delete(int $id)
    {
        return $this->model->findOrfail($id)->delete();
    }

    public function firstOrCreate(array $attributes)
    {
        return $this->model->firstOrCreate($attributes);
    }

    public function paginate(int $number)
    {
        return $this->model->orderBy('created_at', 'desc')->paginate($number);
    }
}
