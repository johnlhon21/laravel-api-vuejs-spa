<?php
/**
 * Created by PhpStorm.
 * User: Marlon.Bagayawa
 * Date: 6/24/2018
 * Time: 12:42 PM
 */

namespace App\Services;


use App\Repositories\Contracts\UserRepositoryContract;
use App\Services\Contracts\UserServiceContract;

class UserService implements UserServiceContract
{
    protected $userRepository;

    public function __construct(UserRepositoryContract $userRepositoryContract)
    {
        $this->userRepository = $userRepositoryContract;
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update(int $userId, array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete(int $userId, array $data)
    {
        // TODO: Implement delete() method.
    }

    public function paginate(int $number)
    {
        // TODO: Implement get() method.
    }

    public function all()
    {

    }
}
