<?php

namespace Shuttle\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\FlashNotifier;
use Shuttle\Http\Requests;
use Shuttle\Http\Controllers\Controller;
use Shuttle\Http\Requests\CreateTripRequest;
use Shuttle\Shuttle;
use Shuttle\Trip;
use Shuttle\User;

class TripController extends Controller
{
    function __construct()
    {
        $this->middleware('manager', ['except' => ['schedule']]);
        $this->middleware('driver', ['only' => 'schedule']);
    }

    public function index()
    {
        $trips = Trip::orderBy('leaves_at')->get();
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

        return back();
    }

    public function destroy($id, FlashNotifier $notifier)
    {
        $trip = Trip::findOrFail($id);

        if ($trip->passengers()->count() > 0)
        {
            $notifier->error('That trip already has passengers. No way we can delete it...');
            return back();
        }

        $trip->delete();

        $notifier->success('Trip successfully deleted!');

        return back();
    }

    public function schedule()
    {
        $trips = Auth::user()->drives()->future()->get();
        return view('trip.schedule', compact('trips'));
    }

}
