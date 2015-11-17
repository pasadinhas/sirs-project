<?php

namespace Shuttle\Http\Controllers;

use Illuminate\Http\Request;

use Shuttle\Http\Requests;
use Shuttle\Http\Controllers\Controller;

class BookingsController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('bookings.index');
    }
}
