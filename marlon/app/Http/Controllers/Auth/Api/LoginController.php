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
use App\Services\Api\Exceptions\EmailNotFoundException;
use App\Services\Api\Exceptions\InvalidPasswordException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    protected $authentication;

    protected $token;

    public function __construct(AuthenticationContract $authenticationContract)
    {
        $this->authentication = $authenticationContract;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function doLogin(Request $request)
    {
        try {
            $response = $this->authentication->authenticate($request);

            return response()->json([
                'data' => $response,
                'class' => 'alert-info',
                'message' => 'Successfully logged in.'
            ], 200);

        } catch (EmailNotFoundException $exception) {

            return response()->json([
                'data' => null,
                'class' => 'alert-danger',
                'message' => $exception->getMessage()
            ], 200);

        } catch (InvalidPasswordException $exception) {

            return response()->json([
                'data' => null,
                'class' => 'alert-danger',
                'message' => $exception->getMessage()
            ], 200);

        } catch (\Exception $exception) {

            Log::info($exception->getTraceAsString());

            return response()->json(['error' => $exception->getMessage()], 500);
        }

    }
}
