<?php

namespace Shuttle\Http\Controllers;

use Auth;
use Shuttle\Http\Controllers\Controller;
use Shuttle\Http\Requests\CreateUserRequest;
use Shuttle\User;

class UserController extends Controller
{
    public function create()
    {
        return view('user.create');
    }

    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
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
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function toggleDriver($id_document)
    {
        $user = User::where('id_document', $id_document)->first();

        $user->is_driver = !($user->is_driver);

        $user->save();

        return redirect(route('user.index'));

    }

}
