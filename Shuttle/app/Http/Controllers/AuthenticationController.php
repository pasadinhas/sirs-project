<?php

namespace Shuttle\Http\Controllers;

use Shuttle\Http\Controllers\Controller;
use Shuttle\Http\Requests\LoginRequest;
use Shuttle\Http\Requests\Request;

class AuthenticationController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (\Auth::attempt(['username' => $request->get('username'), 'password' => $request->get('password')]))
        {
            return redirect()->intended(route('user.profile'));
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
