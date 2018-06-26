<?php
/**
 * Created by PhpStorm.
 * User: Marlon.Bagayawa
 * Date: 6/24/2018
 * Time: 5:49 AM
 */

namespace App\Services\Api\Authentication;


use App\Client\Token;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\AuthClientRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Security\Password;
use App\Services\Api\Exceptions\EmailNotFoundException;
use App\Services\Api\Exceptions\InvalidPasswordException;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Authentication implements AuthenticationContract
{
    /**
     * @var Password
     */
    protected $password;

    /**
     * @var UserRepositoryContract
     */
    protected $userRepository;

    /**
     * @var AuthClientRepositoryContract
     */
    protected $authClientRepository;

    /**
     * @var
     */
    protected $token;

    public function __construct(
        Password $password,
        UserRepositoryContract $userRepositoryContract,
        AuthClientRepositoryContract $authClientRepositoryContract,
        Token $token
    )
    {
        $this->password = $password;
        $this->userRepository = $userRepositoryContract;
        $this->authClientRepository = $authClientRepositoryContract;
        $this->token = $token;
    }

    /**
     * Authenticate and creates Token upon successful login.
     * @param Request $request
     * @throws EmailNotFoundException
     * @throws InvalidPasswordException
     * @return array
     */
    public function authenticate(Request $request)
    {

        $email = $request->post('email');
        $password = $request->post('password');

        $user = $this->userRepository->getCredentials($email);

        Log::info('credentials', [$user]);

        if ($user == null) {
            throw new EmailNotFoundException();
        }

        if (! $this->hasValidPassword($password, $user->password)) {
            throw new InvalidPasswordException();
        }

        return $this->createToken($user);
    }

    /**
     * Checks valid passsword
     * @param $password
     * @param $hash
     * @return bool
     */
    protected function hasValidPassword($password, $hash): bool
    {
        return $this->password->check($password, $hash);
    }

    /**
     * Returns the Token generated
     * @param User
     * @return array
     */
    private function createToken(User $user)
    {
        $this->token->setApiKey($user->authClient->api_key)->generate();

        $data = [
            'token' => $this->token->getToken(),
            'token_expire' => $this->token->expires()->addDay(1)->timestamp
        ];

        $this->token->save($user->id, $data);

        $data['user'] = new UserResource($user);

        return $data;
    }
}
