<?php
/**
 * Created by PhpStorm.
 * User: Marlon.Bagayawa
 * Date: 6/24/2018
 * Time: 6:05 AM
 */

namespace App\Repositories;


use App\Repositories\Contracts\UserRepositoryContract;
use App\User;

class UserRepository extends AbstractRepository implements UserRepositoryContract
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getCredentials($email)
    {
        return $this->model
            ->with(['authClient'])
            ->whereEmail($email)
            ->first();
    }


}
