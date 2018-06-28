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

    /**
     * @param int $userId
     * @return mixed
     */
    public function getByUserId(int $userId)
    {
        return $this->model
            ->whereUserId($userId)
            ->first();
    }

    /**
     * @param string $apiKey
     * @return mixed
     */
    public function getByApiKey(string $apiKey)
    {
        return $this->model
            ->whereApiKey($apiKey)
            ->first();
    }

    /**
     * @param string $token
     * @return mixed
     */
    public function getByToken(string $token)
    {
        return $this->model
            ->whereToken($token)
            ->first();
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function refreshToken(int $id, array $data)
    {
        $authClient = $this->getByUserId($id);
        if ($authClient) {
            return $authClient->update($data);
        }
        return false;
    }

    /**
     * @param array $userIds
     */
    public function multipleDeleteByUserId(array $userIds)
    {
        $this->model->whereIn('user_id', $userIds)->delete();
    }
}
