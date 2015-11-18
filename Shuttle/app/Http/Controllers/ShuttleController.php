<?php

namespace Shuttle\Http\Controllers;

use Shuttle\Http\Controllers\Controller;
use Shuttle\Http\Requests\CreateShuttleRequest;
use Shuttle\Shuttle;

class ShuttleController extends Controller
{

    public function create()
    {
        return view('shuttle.create');
    }

    public function store(CreateShuttleRequest $request)
    {
        Shuttle::create([
            'name' => $request->name,
            'seats' => $request->seats,
            'key' => $request->key,
        ]);
        return redirect('/');
    }

    public function show($name)
    {
        $shuttle = Shuttle::where('name', $name)->first();
        return view('shuttle.show', compact('shuttle'));
    }
}
