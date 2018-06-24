<?php
/**
 * Created by PhpStorm.
 * User: Marlon.Bagayawa
 * Date: 6/24/2018
 * Time: 12:42 PM
 */

namespace App\Services\Contracts;


interface UserServiceContract
{
    public function create(array $data);

    public function first(int $userId);

    public function update(int $userId, array $data);

    public function delete(int $userId);

    public function paginate(int $number);

    public function createAuthClient(array $data);

    public function all();

}
