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
    public function refreshToken($userId, $data);

    public function getByUserId($userId);

    public function getByApiKey($apiKey);

    public function getByToken($token);
}
