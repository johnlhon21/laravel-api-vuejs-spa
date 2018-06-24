<?php
/**
 * Created by PhpStorm.
 * User: Marlon.Bagayawa
 * Date: 6/24/2018
 * Time: 9:06 AM
 */

namespace App\Repositories;


use App\Models\AuthClient;
use App\Repositories\Contracts\AuthClientRepositoryContract;
use Illuminate\Database\Eloquent\Model;

class AuthClientRepository extends AbstractRepository implements AuthClientRepositoryContract
{

    public function __construct(AuthClient $model)
    {
        parent::__construct($model);
    }

    public function getByUserId($userId)
    {
        return $this->model
            ->whereUserId($userId)
            ->first();
    }

    public function getByApiKey($apiKey)
    {
        return $this->model
            ->whereApiKey($apiKey)
            ->first();
    }

    public function getByToken($token)
    {
        return $this->model
            ->whereToken($token)
            ->first();
    }

    public function refreshToken($id, $data)
    {
        return parent::update($id, $data);
    }
}
