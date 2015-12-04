<?php

get('/', ['middleware' => 'guest', function () {
    return view('home');
}]);

/**
 * Shuttle Management
 */

resource('shuttle', 'ShuttleController', ['only' => ['index', 'store', 'destroy']]);
post('shuttle/{id}/key', ['uses' => 'ShuttleController@key', 'as' => 'shuttle.edit.key']);

/**
 * Trip Management
 */

resource('trip', 'TripController', ['only' => ['index', 'store', 'destroy']]);
get('schedule', ['as' => 'trip.schedule', 'uses' => 'TripController@schedule']);

/**
 * Booking Management
 */

resource('booking', 'BookingController', ['only' => ['index', 'store', 'destroy']]);
get('booking/mine', ['as' => 'booking.mine', 'uses' => 'BookingController@mine']);

/**
 * Users Management
 */

resource('user', 'UserController', ['only' => ['index', 'store']]);

get('/user/profile', ['as' => 'user.profile', 'uses' => 'UserController@profile', 'middleware' => 'auth']);
get('/user/{id}/driver', ['as' => 'user.driver', 'uses' => 'UserController@toggleDriver', 'middleware' => 'manager']);
//get('/users/admin/{id_document}', ['as' => 'user.admin', 'uses' => 'UserController@toggleAdmin', 'middleware' => 'admin']);
get('/user/{id}/manager', ['as' => 'user.manager', 'uses' => 'UserController@toggleManager', 'middleware' => 'manager']);
post('/user/{id}/karma', ['as' => 'user.karma', 'uses' => 'UserController@setKarma', 'middleware' => 'manager']);

/**
 * Auth Management
 */

post('/login', ['as' => 'login', 'uses' => 'AuthenticationController@login']);
get('/logout', ['as' => 'logout', 'uses' => 'AuthenticationController@logout']);

/**
 * Secure API
 */

post('/secure/auth', 'SecureController@auth');
post('/secure/trips', 'SecureController@trips');
post('/secure/trip', 'SecureController@trip');
post('/secure/checkin', 'SecureController@checkin');