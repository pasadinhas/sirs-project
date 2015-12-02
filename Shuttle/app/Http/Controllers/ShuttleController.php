<?php

namespace Shuttle\Http\Controllers;

use Laracasts\Flash\FlashNotifier;
use Shuttle\Http\Controllers\Controller;
use Shuttle\Http\Requests\CreateShuttleRequest;
use Shuttle\Shuttle;
use Symfony\Component\HttpFoundation\Request;

class ShuttleController extends Controller
{

    function __construct()
    {
        $this->middleware('manager|driver');
    }

    public function create()
    {
        return view('shuttle.create');
    }

    public function index()
    {
        $shuttles = Shuttle::all();
        return view('shuttle.index', compact('shuttles'));
    }

    public function destroy($id, FlashNotifier $flash)
    {
        $shuttle = Shuttle::find($id);

        if ($shuttle->trips()->future()->count() > 0)
        {
            $flash->error("Shuttle {$shuttle->name} has trips booked so it can't be deleted.");
            return back();
        }

        $shuttle->delete();

        $flash->success('Shuttle successfully deleted!');
        return redirect(route('shuttle.index'));
    }

    public function store(CreateShuttleRequest $request, FlashNotifier $flash)
    {
        Shuttle::create([
            'name' => $request->name,
            'seats' => $request->seats,
            'key' => $request->key,
        ]);
        $flash->success('Shuttle successfully created!');
        return redirect(route('shuttle.index'));
    }

    public function show($name)
    {
        $shuttle = Shuttle::where('name', $name)->first();
        return view('shuttle.show', compact('shuttle'));
    }

    public function key(Request $request)
    {

    }
}
