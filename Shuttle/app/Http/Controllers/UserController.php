<?php

namespace Shuttle\Http\Controllers;

use Shuttle\Http\Controllers\Controller;
use Shuttle\Http\Requests\CreateUserRequest;
use Shuttle\User;

class UserController extends Controller
{
    public function create()
    {
        return view('user.create');
    }

    public function store(CreateUserRequest $request) {
        $u = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'id_document' => $request->id_document,
            'karma' => 10,
        ]);

        return redirect('/');
    }

    public function profile()
    {
        return view('user.profile');
    }
}
