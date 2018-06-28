<?php

namespace Tests\Unit;

use App\Repositories\AuthClientRepository;
use App\Repositories\UserRepository;
use App\Services\Exceptions\EmailAlreadyExistException;
use App\Services\UserService;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserServiceTest extends TestCase
{
    protected $userService;

    protected $userRepository;

    protected $authClientRepository;

    protected $token;

    public function setUp()
    {
        parent::setUp();

        $this->userRepository = \Mockery::mock(UserRepository::class);
        $this->authClientRepository = \Mockery::mock(AuthClientRepository::class);

        $this->userService = new UserService($this->userRepository, $this->authClientRepository);
    }

    /**
     * Test Successful Creating a User
     */
    public function testServiceSuccessfulCreateUser()
    {
        $data = [
            'email' => 'johnlhon2www1@gmail.com',
            'password' => 'password',
            'first_name' => 'Marlon',
            'last_name' => 'Bagayawa',
            'postal_code' => '4500',
            'address' => 'Legazpi City',
            'contact_no' => '124343545',
        ];

        $this->userRepository->shouldReceive('emailExist')->andReturn(false);
        $this->userRepository->shouldReceive('create')->andReturn(new User());

        $result = $this->userService->create($data);

        $this->assertEquals((new User()), $result);
    }

    /**
     * Test Email Already Exist when Creating a User
     */
    public function testServiceCreateUserWithEmailExistThrowsAnEmailAlreadyExistException()
    {
        $this->expectException(EmailAlreadyExistException::class);

        $data = [
            'email' => 'johnlhon2www1@gmail.com',
            'password' => 'password',
            'first_name' => 'Marlon',
            'last_name' => 'Bagayawa',
            'postal_code' => '4500',
            'address' => 'Legazpi City',
            'contact_no' => '124343545',
        ];

        $this->userRepository->shouldReceive('emailExist')->andReturn(true);
        $this->userRepository->shouldReceive('create')->andReturn(new User());

        $this->userService->create($data);
    }

    /**
     * Test Successful Updating a new User
     */
    public function testServiceSuccessfulUpdateUser()
    {
        $data = [
            'email' => 'johnlhon2www1@gmail.com',
            'password' => 'password',
            'first_name' => 'Marlon',
            'last_name' => 'Bagayawa',
            'postal_code' => '4500',
            'address' => 'Legazpi City',
            'contact_no' => '124343545',
        ];

        $userId = 1;

        $this->userRepository->shouldReceive('emailExist')->andReturn(false);
        $this->userRepository->shouldReceive('update')->andReturn(new User());

        $result = $this->userService->update($userId, $data);

        $this->assertEquals((new User()), $result);
    }

    /**
     * Test Email Already Exist when Updating a User
     */
    public function testServiceUpdateUserWithEmailExistThrowsAnEmailAlreadyExistException()
    {
        $this->expectException(EmailAlreadyExistException::class);

        $data = [
            'email' => 'johnlhon2www1@gmail.com',
            'password' => 'password',
            'first_name' => 'Marlon',
            'last_name' => 'Bagayawa',
            'postal_code' => '4500',
            'address' => 'Legazpi City',
            'contact_no' => '124343545',
        ];

        $userId = 1;

        $this->userRepository->shouldReceive('emailExist')->andReturn(true);
        $this->userRepository->shouldReceive('update')->andReturn(new User());

        $this->userService->update($userId, $data);
    }

    /**
     * Test Successful Delete User
     */
    public function testServiceSuccessfulDeleteUser()
    {
        $userId = 1;

        $this->userRepository->shouldReceive('delete')->andReturn(true);
        $result = $this->userService->delete($userId);

        $this->assertTrue($result);
    }

    /**
     * Test UnSuccessful Delete User
     */
    public function testServiceUnSuccessfulDeleteUser()
    {
        $userId = 1;

        $this->userRepository->shouldReceive('delete')->andReturn(false);
        $result = $this->userService->delete($userId);

        $this->assertFalse($result);
    }

    /**
     * Test Successful Multi Delete User
     */
    public function testServiceSuccessfulMultipleDeleteUser()
    {
        $userIds = [1,2,3];

        $this->userRepository->shouldReceive('deleteUsers')->andReturn(true);
        $this->authClientRepository->shouldReceive('multipleDeleteByUserId')->andReturn(true);
        $result = $this->userService->deleteUsers($userIds);

        $this->assertTrue($result);
    }

    /**
     * Test UnSuccessful Multi Delete User
     */
    public function testServiceUnSuccessfulMultipleDeleteUser()
    {
        $userIds = [1,2,3];

        $this->userRepository->shouldReceive('deleteUsers')->andReturn(false);
        $this->authClientRepository->shouldReceive('multipleDeleteByUserId')->andReturn(false);
        $result = $this->userService->deleteUsers($userIds);

        $this->assertFalse($result);
    }
}
