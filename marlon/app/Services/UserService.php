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
use App\Services\Exceptions\EmailAlreadyExistException;

class UserService implements UserServiceContract
{
    /**
     * @var UserRepositoryContract
     */
    protected $userRepository;

    /**
     * @var AuthClientRepositoryContract
     */
    protected $authClientRepository;

    public function __construct(
        UserRepositoryContract $userRepositoryContract,
        AuthClientRepositoryContract $authClientRepositoryContract
    )
    {
        $this->userRepository = $userRepositoryContract;
        $this->authClientRepository = $authClientRepositoryContract;
    }

    /**
     * @param int $number
     * @return mixed
     */
    public function paginate(int $number)
    {
        return $this->userRepository->paginate($number);
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function first(int $userId)
    {
        return $this->userRepository->getById($userId);
    }

    /**
     * @param array $data
     * @return mixed
     * @throws EmailAlreadyExistException
     */
    public function create(array $data)
    {
        $exist = $this->userRepository->emailExist($data['email']);

        if ($exist) {
            throw new EmailAlreadyExistException();
        }

        return $this->userRepository->create($data);
    }

    /**
     * @param int $userId
     * @param array $data
     * @return mixed
     */
    public function update(int $userId, array $data)
    {
        return $this->userRepository->update($userId, $data);
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function delete(int $userId)
    {
        return $this->userRepository->delete($userId);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createAuthClient(array $data)
    {
        return $this->authClientRepository->create($data);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->userRepository->getAll();
    }

    /**
     * @param array $userIds
     * @return mixed
     */
    public function deleteUsers(array $userIds)
    {
        $this->authClientRepository->multipleDeleteByUserId($userIds);
        return $this->userRepository->deleteUsers($userIds);
    }
}
