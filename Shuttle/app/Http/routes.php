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

post('/login', ['as' => 'login', 'uses' => 'AuthenticationController@login']);

get('/logout', ['as' => 'logout', 'uses' => 'AuthenticationController@logout']);

get('/booking', ['as' => 'booking', 'uses' => 'BookingController@index']);

get('/users/create', ['as' => 'user.create', 'uses' => 'UserController@create']);

post('/users', ['as' => 'user.store', 'uses' => 'UserController@store']);

get('/users/profile', ['as' => 'user.profile', 'uses' => 'UserController@profile', 'middleware' => 'auth']);

get('/users/driver/{id_document}', ['as' => 'user.driver', 'uses' => 'UserController@toggleDriver', 'middleware' => 'manager']);

get('/users/admin/{id_document}', ['as' => 'user.admin', 'uses' => 'UserController@toggleAdmin', 'middleware' => 'admin']);

get('/users/manager/{id_document}', ['as' => 'user.manager', 'uses' => 'UserController@toggleManager', 'middleware' => 'manager']);

post('/users/karma/{id_document}', ['as' => 'user.karma', 'uses' => 'UserController@setKarma', 'middleware' => 'manager']);

get('/users/', ['as' => 'user.index', 'uses' => 'UserController@index', 'middleware' => 'manager']);

get('/shuttle/create', ['as' => 'shuttle.create', 'uses' => 'ShuttleController@create', 'middleware' => 'manager']);

get('/shuttle/', ['as' => 'shuttle.index', 'uses' => 'ShuttleController@index', 'middleware' => 'manager']);

get('/shuttle/delete/{id}', ['as' => 'shuttle.delete', 'uses' => 'ShuttleController@delete']);

post('/shuttle', ['as' => 'shuttle.store', 'uses' => 'ShuttleController@store', 'middleware' => 'manager']);

get('/trip/create', ['as' => 'trip.create', 'uses' => 'TripController@create', 'middleware' => 'manager']);

get('/trip/', ['as' => 'trip.index', 'uses' => 'TripController@index', 'middleware' => 'manager']);

post('/trip', ['as' => 'trip.store', 'uses' => 'TripController@store', 'middleware' => 'manager']);

get('/booking/create', ['as' => 'booking.create', 'uses' => 'BookingController@create', 'middleware' => 'auth']);

post('/booking', ['as' => 'booking.store', 'uses' => 'BookingController@store', 'middleware' => 'auth']);

/* THE KEY IS SHOWN! DON'T PUSH TO PRODUCTION!! pls :) */
get('/shuttle/{name}', ['as' => 'shuttle.show', 'uses' => 'ShuttleController@show']);

/**
 * Secure routing
 */

post('/secure/handshake', 'SecureController@handshake');
post('/secure/handshake/auth', 'SecureController@authHandshake');
post('/secure/auth', 'SecureController@auth');
