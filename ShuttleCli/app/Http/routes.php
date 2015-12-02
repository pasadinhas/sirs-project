<?php

get('/', 'ShuttleController@home');
get('/trips', 'ShuttleController@trips');

$router->group([
    'prefix' => 'secure',
    'as' => 'secure.',
], function() {
    post('login', ['as' => 'login', 'uses' => 'SecureController@login']);
    get('logout', ['as' => 'logout', 'uses' => 'SecureController@logout']);
});