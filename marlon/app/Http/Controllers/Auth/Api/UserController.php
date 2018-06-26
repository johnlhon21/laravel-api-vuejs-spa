<?php
/**
 * Created by PhpStorm.
 * User: Marlon.Bagayawa
 * Date: 6/24/2018
 * Time: 8:40 AM
 */

namespace App\Http\Controllers\Auth\Api;


use App\Client\KeyGenerator;
use App\Client\Token;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Security\Password;
use App\Services\Contracts\UserServiceContract;
use App\Services\Exceptions\EmailAlreadyExistException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $userService;

    protected $password;

    public function __construct(
        UserServiceContract $userServiceContract,
        Password $password
    )
    {
        $this->userService = $userServiceContract;
        $this->password = $password;
    }

    public function getUsers()
    {
        try {

            $users = $this->userService->paginate(10);

            return UserResource::collection($users);

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return response()->json(['error' => 'Error retrieving users.', 'data' => null], 500);

        }
    }

    public function getUser(int $userId)
    {
        try {

            $user = $this->userService->first($userId);

            return new UserResource($user);

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return response()->json(['error' => 'Error retrieving user.', 'data' => null], 500);

        }
    }

    public function createUser(Request $request)
    {
        try {

            $data = [
                'email' => $request->post('email'),
                'password' => $this->password->hash($request->post('password')),
                'first_name' => $request->post('first_name'),
                'last_name' => $request->post('last_name'),
                'postal_code' => $request->post('postal_code'),
                'address' => $request->post('address'),
                'contact_no' => $request->post('contact_no'),
            ];

            $user = $this->userService->create($data);

            $authClient = [
                'user_id' => $user->id,
                'api_key' => KeyGenerator::generate()->apiKey($user->id)
            ];

            $this->userService->createAuthClient($authClient);

            return new UserResource($user);

        } catch (EmailAlreadyExistException $exception) {

            Log::error($exception->getTraceAsString());

            return response()->json(['message' => $exception->getMessage(), 'data' => null], 200);

        } catch (\Exception $exception) {

            Log::error($exception->getTraceAsString());

            return response()->json(['error' => 'Error creating user.', 'data' => null], 500);

        }
    }

    public function deleteUser($userId)
    {
        try {

            $user = $this->userService->first($userId);

            if ($user->delete($user)) {
                return new UserResource($user);
            }

            return response()->json(['message' => 'User not found.', 'data' => null], 200);

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return response()->json(['error' => 'Error deleting user.', 'data' => null], 500);

        }
    }

    public function updateUser(int $userId, Request $request)
    {
        try {

            $data = [
                'email' => $request->post('email'),
                'password' => $this->password->hash($request->post('password')),
                'first_name' => $request->post('first_name'),
                'last_name' => $request->post('last_name'),
                'postal_code' => $request->post('postal_code'),
                'address' => $request->post('address'),
                'contact_no' => $request->post('contact_no'),
            ];

            $this->userService->update($userId, $data);

            return new UserResource($this->userService->first($userId));

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return response()->json(['error' => 'Error updating user.', 'data' => null], 500);
        }
    }

    public function deleteUsers(Request $request)
    {
        try {

            $this->userService->deleteUsers($request->post('user_ids'));

            return response()->json(['message' => 'Users deleted.', 'data' => null], 200);

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return response()->json(['error' => 'Error deleting user.', 'data' => null], 500);

        }
    }
}
