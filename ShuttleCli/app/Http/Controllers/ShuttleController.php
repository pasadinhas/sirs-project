<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 28/11/15
 * Time: 21:19
 */

namespace ShuttleCli\Http\Controllers;

use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Support\Facades\Cache;
use ShuttleCli\Services\SecureService;

class ShuttleController extends Controller
{
    private $secure;

    function __construct(Encrypter $encrypter)
    {
        $this->secure = new SecureService($encrypter);
    }

    public function trips()
    {
        if ( ! Cache::has('trips'))
        {
            $trips = $this->secure->trips();
            Cache::put('trips', $trips, 120);
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