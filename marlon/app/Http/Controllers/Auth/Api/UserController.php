<?php
/**
 * Created by PhpStorm.
 * User: Marlon.Bagayawa
 * Date: 6/24/2018
 * Time: 8:40 AM
 */

namespace App\Http\Controllers\Auth\Api;


use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.custom');
    }

    public function getUsers()
    {
        dd('yeah');
    }
}
