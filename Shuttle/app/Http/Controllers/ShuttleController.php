<?php

namespace Shuttle\Http\Controllers;

use Laracasts\Flash\FlashNotifier;
use Shuttle\Http\Controllers\Controller;
use Shuttle\Http\Requests\CreateShuttleRequest;
use Shuttle\Shuttle;

class ShuttleController extends Controller
{

    public function create()
    {
        return view('shuttle.create');
    }

    public function store(CreateShuttleRequest $request, FlashNotifier $flash)
    {
        Shuttle::create([
            'name' => $request->name,
            'seats' => $request->seats,
            'key' => $request->key,
        ]);
        $flash->success('Shuttle successfully created!');
        return redirect('/');
    }

    public function show($name)
    {
        $shuttle = Shuttle::where('name', $name)->first();
        return view('shuttle.show', compact('shuttle'));
    }
}
