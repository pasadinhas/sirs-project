<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

get('/', function () {
    return view('home');
});

$router->controller('secure', 'SecureController');

post('/login', ['as' => 'login', 'uses' => 'AuthenticationController@login']);

get('/logout', ['as' => 'logout', 'uses' => 'AuthenticationController@logout']);

get('/bookings', ['as' => 'bookings', 'uses' => 'BookingsController@index']);

get('/users/create', ['as' => 'user.create', 'uses' => 'UserController@create']);

post('/users', ['as' => 'user.store', 'uses' => 'UserController@store']);

get('/users/profile', ['as' => 'user.profile', 'uses' => 'UserController@profile', 'middleware' => 'auth']);


