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
        return view('booking.index');
    }

    public function create()
    {
        return view('booking.create');
    }

    public function store(CreateBookingRequest $request, FlashNotifier $flash)
    {
        if ( ! Trip::find($request->trip_id))
        {
            $flash->error("Error creating booking. Trip $request->trip_id does not exist.");
            return redirect()->back()->withInput();
        }

        Booking::create([
            'trip_id' => $request->trip_id,
            'user_id' => Auth::user()->id,
        ]);

        $flash->success('Booking successfully created!');
        return redirect('/');
    }
}
