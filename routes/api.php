<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', 'Auth\Api\LoginController@doLogin');

Route::get('/users', 'Auth\Api\UserController@getUsers')->middleware('auth.custom');
Route::post('/users/multi-delete', 'Auth\Api\UserController@deleteUsers')->middleware('auth.custom');


Route::group(['prefix' => 'user',  'middleware' => 'auth.custom'], function() {
    Route::post('/', 'Auth\Api\UserController@createUser');
    Route::get('{id}', 'Auth\Api\UserController@getUser');
    Route::delete('{id}', 'Auth\Api\UserController@deleteUser');
    Route::put('{id}', 'Auth\Api\UserController@updateUser');
});

