<?php

namespace Shuttle\Http\Controllers;

use Illuminate\Http\Request;
use Shuttle\Http\Controllers\Controller;
use Shuttle\Http\Requests\LoginRequest;

class AuthenticationController extends Controller
{
    function __construct()
    {
        $this->middleware('guest', ['only' => 'login']);
        $this->middleware('auth', ['only' => 'logout']);
    }

    public function login(LoginRequest $request)
    {
        if (\Auth::attempt(['username' => $request->get('username'), 'password' => $request->get('password')]))
        {
            //return redirect()->intended(route('user.profile'));
            return redirect('/');
        }
        else
        {
            return redirect()->back();
        }
    }

    public  function logout()
    {
        \Auth::logout();

        return redirect('/');
    }
}
