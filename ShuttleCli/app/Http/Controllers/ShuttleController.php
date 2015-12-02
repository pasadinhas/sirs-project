<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 28/11/15
 * Time: 21:19
 */

namespace ShuttleCli\Http\Controllers;

use Illuminate\Cache\Repository;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Cache;
use ShuttleCli\Services\SecureService;

class ShuttleController extends Controller
{
    private $secure;
    private $cache;

    function __construct(Encrypter $encrypter, Repository $cache)
    {
        $this->cache = $cache;
        $this->secure = new SecureService($encrypter, $cache);
        $this->middleware('busdriver', ['except' => 'home']);
        $this->middleware('guest', ['only' => 'home']);
    }

    public function home()
    {
        return view('home');
    }

    public function trips()
    {
        if ( true || ! Cache::has('trips'))
        {
            $trips = $this->secure->trips();
            Cache::put('trips', $trips, 1);
        }
        else
        {
            $trips = Cache::get('trips');
        }

        return view('shuttle.trips', compact('trips'));
    }

    public function trip($id)
    {
        // TODO: validate $id

        if ( ! Cache::has("trips.$id"))
        {
            $trip = $this->secure->trip($id);
            Cache::put("trips.$id", $trip, 120);
        }
        else
        {
            $trip = Cache::get("trips.$id");
        }

        return view('shuttle.trip', compact('trip'));
    }
}