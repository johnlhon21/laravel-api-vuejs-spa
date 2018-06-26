<?php
/**
 * Created by PhpStorm.
 * User: Marlon.Bagayawa
 * Date: 6/24/2018
 * Time: 9:07 AM
 */

namespace App\Repositories\Contracts;


interface AuthClientRepositoryContract
{
    public function refreshToken(int $userId, array $data);

    public function getByUserId(int $userId);

    public function getByApiKey(string $apiKey);

    public function getByToken(string $token);

    public function multipleDeleteByUserId(array $userId);
}
