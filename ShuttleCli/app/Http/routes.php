<?php

get('/', function () {
    return view('home');
});

get('/trips', 'ShuttleController@trips');

$router->group([
    'prefix' => 'secure',
    'as' => 'secure.',
], function() {
    post('login', ['as' => 'login', 'uses' => 'SecureController@login']);
});