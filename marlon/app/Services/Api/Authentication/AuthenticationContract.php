<?php
/**
 * Created by PhpStorm.
 * User: Marlon.Bagayawa
 * Date: 6/24/2018
 * Time: 5:51 AM
 */

namespace App\Services\Api\Authentication;


use Illuminate\Http\Request;

interface AuthenticationContract
{
    public function authenticate(Request $request);
}
