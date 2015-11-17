<?php

get('/', function () {
    return view('home');
});

$router->group([
    'prefix' => 'secure',
    'as' => 'secure.',
], function() {
    post('login', ['as' => 'login', 'uses' => 'SecureController@login']);
    get('foo', 'SecureController@foo');
    get('/', function() {
        var_dump(Input::all());
    });
});