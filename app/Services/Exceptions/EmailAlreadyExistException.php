<?php
/**
 * Created by PhpStorm.
 * User: Marlon.Bagayawa
 * Date: 6/26/2018
 * Time: 3:38 AM
 */

namespace App\Services\Exceptions;


class EmailAlreadyExistException extends \Exception
{
    protected $message = 'Email address already taken.';
}
