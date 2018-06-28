<?php
/**
 * Created by PhpStorm.
 * User: Marlon.Bagayawa
 * Date: 6/24/2018
 * Time: 6:55 AM
 */

namespace App\Services\Api\Exceptions;


class InvalidPasswordException extends \Exception
{
    protected $message = 'Invalid Password.';
}
