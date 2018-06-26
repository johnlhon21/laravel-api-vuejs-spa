## Laravel & VueJS API Simple CRUD using Single Page Application
This is a simple CRUD Application using Laravel & VueJs & SPA `Single Page Application` and JWT Authorization for the security of all API endpoints.
## Installation

## Laravel Server
  - Setup Vagrant Homestead or Docker
  - Refer Database connection to `.env` file
  - run `composer install`
  - run `php artisan migrate`
  - run `php artisan db:seed`
## Node Modules
  - run `npm-install --no-bin-links`  
  - run `npm install --global cross-env` if required to install
  - run `npm run dev`
## Unit Testing
  - run `./vendor/bin/phpunit --testsuite Unit`
  - TestCase file
    - `Tests\Unit\UserServiceTest.php`
    - `Tests\Unit\AuthenticationTest.php`
## Authorization
  - This application uses `JWT` authorization for API endpoints.
  - Tokens, Open the file `Authentication.php`
    - Set the expiration using `Carbon Object` 
      ```php 
      $this->token->expires()->addDay(1)->timestamp
      ```
    - In this application the Token were stored in `Vuex Persist Store` to automatically add the headers for every request.
    - If using `Postman` add the following headers for every request  
      - `Authorization: Bearer TokenGenerated`
      - `Content-Type : application/json`
## Endpoints
  ```php
    Route::post('/login', 'Auth\Api\LoginController@doLogin');
    
    Route::get('/users', 'Auth\Api\UserController@getUsers')->middleware('auth.custom');
    Route::post('/users/multi-delete', 'Auth\Api\UserController@deleteUsers')->middleware('auth.custom');
    
    
    Route::group(['prefix' => 'user',  'middleware' => 'auth.custom'], function() {
        Route::post('/', 'Auth\Api\UserController@createUser');
        Route::get('{id}', 'Auth\Api\UserController@getUser');
        Route::delete('{id}', 'Auth\Api\UserController@deleteUser');
        Route::put('{id}', 'Auth\Api\UserController@updateUser');
    });
  ```   
  - Token Generated will be returned if the user were successfully authenticated.
  ## Default User & Password
   - Please see `UserSeeder.php`
   - email : `johnlhon21@gmail.com`
   - password : `password`

## Note from developer

I mainly used the `passport` oauth authentication for large applications especially with Laravel. For this project I created a **Custom API** authentication / authorization using [JWT](https://jwt.io/) `(JSON Web Token)` to show some coding stuff (OOP) instead of just installing.
