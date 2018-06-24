<?php
/**
 * Created by PhpStorm.
 * User: Marlon.Bagayawa
 * Date: 6/24/2018
 * Time: 6:25 AM
 */

namespace App\Http\Controllers\Auth\Api;


use App\Http\Controllers\Controller;
use App\Services\Api\Authentication\AuthenticationContract;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $authentication;

    protected $token;

    public function __construct(AuthenticationContract $authenticationContract)
    {
        $this->authentication = $authenticationContract;
    }

    public function doLogin(Request $request)
    {
        try {

            $response = $this->authentication->authenticate($request);

            return response()->json(['data' => $response], 200);

        } catch (\Exception $exception) {

            return response()->json(['error' => $exception->getMessage()], 500);
        }

    }
}
