<?php

get('/', function () {
    return view('home');
});

/**
 * Shuttle Management
 */

resource('shuttle', 'ShuttleController', ['only' => ['index', 'show', 'store', 'create', 'destroy']]);
post('shuttle/{id}/key', ['uses' => 'ShuttleController@key', 'as' => 'shuttle.edit.key']);

/**
 * Trip Management
 */

resource('trip', 'TripController', ['only' => ['index', 'show', 'store', 'create', 'destroy']]);

/**
 * Booking Management
 */

resource('booking', 'BookingController', ['only' => ['index', 'store', 'destroy']]);
get('booking/mine', ['as' => 'booking.mine', 'uses' => 'BookingController@mine']);

/**
 * Users Management
 */

resource('user', 'UserController');

get('/users/profile', ['as' => 'user.profile', 'uses' => 'UserController@profile', 'middleware' => 'auth']);
get('/users/driver/{id_document}', ['as' => 'user.driver', 'uses' => 'UserController@toggleDriver', 'middleware' => 'manager']);
get('/users/admin/{id_document}', ['as' => 'user.admin', 'uses' => 'UserController@toggleAdmin', 'middleware' => 'admin']);
get('/users/manager/{id_document}', ['as' => 'user.manager', 'uses' => 'UserController@toggleManager', 'middleware' => 'manager']);
post('/users/karma/{id_document}', ['as' => 'user.karma', 'uses' => 'UserController@setKarma', 'middleware' => 'manager']);

/**
 * Auth Management
 */

post('/login', ['as' => 'login', 'uses' => 'AuthenticationController@login']);
get('/logout', ['as' => 'logout', 'uses' => 'AuthenticationController@logout']);

/**
 * Secure API
 */

post('/secure/handshake', 'SecureController@handshake');
post('/secure/handshake/auth', 'SecureController@authHandshake');
post('/secure/auth', 'SecureController@auth');
