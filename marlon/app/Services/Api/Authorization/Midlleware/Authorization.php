<?php
/**
 * Created by PhpStorm.
 * User: Marlon.Bagayawa
 * Date: 6/24/2018
 * Time: 8:22 AM
 */

namespace App\Services\Api\Authorization\Middleware;


use App\Services\Api\Authorization\Guard\Guard;
use Illuminate\Support\Facades\Log;

class Authorization
{
    /**
     * Handle an incoming request.
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        try {

            $authorize = Guard::authorize()->jwt($request);

            if (! $authorize) {
                return $this->unAuthorized();
            }

            return $next($request);

        } catch (\Exception $exception) {

            return $this->error($exception);

        }
    }

    /**
     * Returns Status 500
     * @param \Exception $exception
     * @return \Illuminate\Http\JsonResponse
     */
    private function error(\Exception $exception)
    {
        Log::error($exception->getMessage());

        return response()->json([
            'status' => 500,
            'message' => 'Error : Bad Request',
            'description' => $exception->getMessage()
        ], 500);
    }

    /**
     * Returns Status 401
     * @return \Illuminate\Http\JsonResponse
     */
    private function unAuthorized()
    {
        Log::info('Unauthorized Request');

        return response()->json([
            'status' => 401,
            'message' => 'Error : Unauthorized',
            'description' => 'Invalid authorization token'
        ], 401);
    }
}
