<?php

namespace App\Services\Api\Authorization\Guard;


use App\Services\Api\Authorization\JwtAuthorization;
use Illuminate\Http\Request;

/**
 * Class Guard
 * @package App\Services\Api\Authorization\Guard
 */
class Guard
{

    /**
     * @return static
     */
    public static function authorize()
    {
        return new static();
    }

    /**
     * JWT Authentication
     * @param Request $request
     * @return bool
     */
    public function jwt(Request $request)
    {
        return (new JwtAuthorization($request))->authorize();
    }
}
