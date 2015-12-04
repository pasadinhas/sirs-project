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
        $this->middleware('manager');
    }

    public function index()
    {
        $shuttles = Shuttle::all();
        return view('shuttle.index', compact('shuttles'));
    }

    public function destroy($id, FlashNotifier $flash)
    {
        $shuttle = Shuttle::findOrFail($id);

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

    public function key(Request $request, FlashNotifier $flash)
    {
        $shuttle = Shuttle::findOrFail($request->get('id'));

        $shuttle->key = $request->get('key');

        $flash->success('Shuttle key successfully modified!');

        return back();
    }
}
