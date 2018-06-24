<?php
/**
 * Created by PhpStorm.
 * User: Marlon.Bagayawa
 * Date: 6/24/2018
 * Time: 12:42 PM
 */

namespace App\Services;


use App\Repositories\Contracts\AuthClientRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Services\Contracts\UserServiceContract;

class UserService implements UserServiceContract
{
    protected $userRepository;

    protected $authClientRepository;

    public function __construct(
        UserRepositoryContract $userRepositoryContract,
        AuthClientRepositoryContract $authClientRepositoryContract
    )
    {
        $this->userRepository = $userRepositoryContract;
        $this->authClientRepository = $authClientRepositoryContract;
    }

    public function paginate(int $number)
    {
        return $this->userRepository->paginate($number);
    }

    public function first(int $userId)
    {
        return $this->userRepository->getById($userId);
    }


    public function create(array $data)
    {
        return $this->userRepository->create($data);
    }

    public function update(int $userId, array $data)
    {
        return $this->userRepository->update($userId, $data);
    }

    public function delete(int $userId)
    {
        return $this->userRepository->delete($userId);
    }

    public function createAuthClient(array $data)
    {
        return $this->authClientRepository->create($data);
    }

    public function all()
    {
        return $this->userRepository->getAll();
    }
}
