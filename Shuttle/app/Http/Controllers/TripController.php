<?php

namespace Shuttle\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Laracasts\Flash\FlashNotifier;
use Shuttle\Http\Requests;
use Shuttle\Http\Controllers\Controller;
use Shuttle\Http\Requests\CreateTripRequest;
use Shuttle\Shuttle;
use Shuttle\Trip;
use Shuttle\User;

class TripController extends Controller
{
    public function create()
    {
        return view('trip.create');
    }

    public function index()
    {
        $trips = Trip::all();
        return view('trip.index', compact('trips'));
    }

    public function store(CreateTripRequest $request, FlashNotifier $flash)
    {
        if ( ! Shuttle::find($request->shuttle_id))
        {
            $flash->error("Error creating trip. Shuttle $request->id does not exist.");
            return redirect()->back()->withInput();
        }

        $driver = User::find($request->driver_id);

        if ($driver == null)
        {
            $flash->error("Error creating trip. User $request->driver_id does not exist.");
            return redirect()->back()->withInput();
        }

        if ( ! $driver->isDriver())
        {
            $flash->error("Error creating trip. User $driver->name is not a driver.");
            return redirect()->back()->withInput();
        }

        $leaves = new Carbon($request->leaves_at);
        $arrives = new Carbon($request->arrives_at);

        Trip::create([
            'shuttle_id' => $request->shuttle_id,
            'driver_id' => $request->driver_id,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'leaves_at' => $leaves,
            'arrives_at' => $arrives,
        ]);

        $flash->success('Trip successfully created!');
        return redirect('/');
    }

    public function show($name)
    {

    }
}
