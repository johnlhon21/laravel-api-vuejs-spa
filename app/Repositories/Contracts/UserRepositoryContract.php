<?php
/**
 * Created by PhpStorm.
 * User: Marlon.Bagayawa
 * Date: 6/24/2018
 * Time: 6:05 AM
 */

namespace App\Repositories\Contracts;


interface UserRepositoryContract
{
    public function getCredentials($email);

    public function emailExist($email);

    public function deleteUsers(array $userIds);
}
