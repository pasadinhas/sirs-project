<?php

get('/', 'ShuttleController@home');
get('/trips', 'ShuttleController@trips');
get('/trip/{id}', 'ShuttleController@trip');
get('/trip/{id}/send', 'SecureController@send');

post('/checkin', function()
{
    \ShuttleCli\Attendance::create(\Illuminate\Support\Facades\Input::all());
    return back();
});

post('/checkout', function()
{
    $a = \ShuttleCli\Attendance::where('user', \Illuminate\Support\Facades\Input::get('user'))
        ->where('trip', \Illuminate\Support\Facades\Input::get('trip'))
        ->first();

    if ($a) $a->delete();

    return back();
});



$router->group([
    'prefix' => 'secure',
    'as' => 'secure.',
], function() {
    post('login', ['as' => 'login', 'uses' => 'SecureController@login']);
    get('logout', ['as' => 'logout', 'uses' => 'SecureController@logout']);
});