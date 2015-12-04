<?php

namespace ShuttleCli\Http\Controllers;

use Illuminate\Cache\Repository;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;
use ShuttleCli\Attendance;
use ShuttleCli\Http\Requests;
use ShuttleCli\Services\SecureService;
use ShuttleCli\Trip;

class SecureController extends Controller
{
    private $service;
    private $cache;

    public function __construct(Encrypter $encrypter, Repository $cache)
    {
        $this->middleware('busdriver', ['except' => 'login']);
        $this->middleware('guest', ['only' => 'login']);
        $this->service = new SecureService($encrypter, $cache);
        $this->cache = $cache;
    }

    public function login(Request $request)
    {
        try
        {
            $this->service->login($request);
        }
        catch (\Exception $e)
        {
            return redirect('/')->with('error', 'Login failed');
        }

        return redirect('/trips');
    }

    public function logout()
    {
        Cache::flush();

        return redirect('/');
    }

    public function send($id)
    {
        if ( ! is_numeric($id))
        {
            return back();
        }

        if (Trip::where('trip_id', $id)->first() != null)
        {
            throw new \Exception("Trip already sent to server");
        }

        $this->service->send(Attendance::where('trip', $id)->get()->toArray(), $id);

        Trip::create(['trip_id' => $id]);

        return redirect()->back();
    }

}
