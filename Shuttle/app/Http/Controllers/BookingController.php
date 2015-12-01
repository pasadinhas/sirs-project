<?php

namespace Shuttle\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\FlashNotifier;
use Shuttle\Booking;
use Shuttle\Http\Requests;
use Shuttle\Http\Controllers\Controller;
use Shuttle\Http\Requests\CreateBookingRequest;
use Shuttle\Trip;

class BookingController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $trips = Trip::all();

        $reservations = Auth::user()->reservations;

        return view('booking.index', compact('trips', 'reservations'));
    }

    public function store(CreateBookingRequest $request, FlashNotifier $flash)
    {
        $trip = Trip::findOrFail($request->get('trip_id'));

        $trip->passengers()->attach(Auth::user()->id);

        $flash->success("You successfully booked a trip from {$trip->origin} to {$trip->destination}!");

        return redirect(route('booking.index'));
    }

    public function destroy(Request $request, FlashNotifier $flash)
    {
        $trip = Trip::findOrFail($request->get('trip_id'));

        $trip->passengers()->detach(Auth::user()->id);

        $flash->error("Your reservation from {$trip->origin} to {$trip->destination} was canceled.");

        return redirect()->back();
    }

    public function mine()
    {
        $reservations = Auth::user()->reservations;
        return view('booking.mine', compact('reservations'));
    }
}
