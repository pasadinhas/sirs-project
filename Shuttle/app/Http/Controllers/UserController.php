<?php

namespace Shuttle\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Laracasts\Flash\FlashNotifier;
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

    public function toggleDriver($id, FlashNotifier $flash)
    {
        $user = User::find($id);

        if ($user->isDriver() && $user->drives()->future()->count() > 0)
        {
            $flash->error("{$user->name} has Trips he needs to drive so he must stay a driver.");
            return back();
        }

        $user->is_driver = !($user->is_driver);

        $user->save();

        return back();

    }

    public function toggleAdmin($id_document)
    {
        $user = User::where('id_document', $id_document)->first();

        $user->is_admin = !($user->is_admin);

        $user->save();

        return redirect(route('user.index'));

    }

    public function toggleManager($id)
    {
        $user = User::find($id);

        $user->is_manager = !($user->is_manager);

        $user->save();

        return redirect()->back();

    }

    //TODO: NOT WORKING
    public function setKarma(Request $request, $id)
    {
        $user = User::find($id);

        $user->karma = $request->get('karma');

        $user->save();

        return redirect(route('user.index'));

    }

}
