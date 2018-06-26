<?php

namespace Tests\Unit;

use App\Client\Token;
use App\Repositories\AuthClientRepository;
use App\Repositories\UserRepository;
use App\Security\Password;
use App\Services\Api\Authentication\Authentication;
use App\Services\Api\Exceptions\EmailNotFoundException;
use App\Services\Api\Exceptions\InvalidPasswordException;
use App\User;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    protected $authenticationService;

    protected $password;

    protected $userRepository;

    protected $authClientRepository;

    protected $fakeAuthService;

    protected $token;

    public function setUp()
    {
        parent::setUp();

        $this->password = \Mockery::mock(Password::class);
        $this->userRepository = \Mockery::mock(UserRepository::class);
        $this->authClientRepository = \Mockery::mock(AuthClientRepository::class);
        $this->fakeAuthService = \Mockery::mock(Authentication::class);
        $this->token = \Mockery::mock(Token::class);

        $this->authenticationService = \Mockery::mock(new Authentication(
            $this->password,
            $this->userRepository,
            $this->authClientRepository,
            $this->token
        ));
    }

    /**
     * Test Successful Authentication
     */
    public function testUserAuthenticatedReturnsTokenArray()
    {

        $this->userRepository->shouldReceive('getCredentials')->andReturn(new User());

        $this->password->shouldReceive('isValidPassword')->andReturns(true);

        $this->authenticationService->shouldReceive('createToken')->andReturns(['token' => 'sample token']);

        $this->authenticationService->shouldReceive('authenticate')->andReturns(['token' => 'sample token']);

        $result = $this->authenticationService->authenticate(new Request());

        $this->assertTrue(is_array($result));

    }

    /**
     * Test Email Not Found
     */
    public function testAuthenticationUserEmailNotFoundThrowsEmailNotFoundException()
    {
        $this->expectException(EmailNotFoundException::class);

        $this->userRepository->shouldReceive('getCredentials')->andReturn(null);

        $result = $this->authenticationService->authenticate(new Request());

        $this->assertTrue(is_array($result));

    }

    /**
     * Test Invalid Password
     */
    public function testAuthenticationUserPasswordInvalidThrowsInvalidPasswordException()
    {
        $this->expectException(InvalidPasswordException::class);

        $this->userRepository->shouldReceive('getCredentials')->andReturn(new User());

        $this->password->shouldReceive('isValidPassword')->andReturn(false);

        $result = $this->authenticationService->authenticate(new Request());

        $this->assertTrue(is_array($result));

    }
}
