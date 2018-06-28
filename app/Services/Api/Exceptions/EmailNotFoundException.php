<?php
/**
 * Created by PhpStorm.
 * User: Marlon.Bagayawa
 * Date: 6/24/2018
 * Time: 6:47 AM
 */

namespace App\Services\Api\Exceptions;


class EmailNotFoundException extends \Exception
{
    protected $message = 'Email Not Found.';
}
