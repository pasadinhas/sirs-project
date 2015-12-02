<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 28/11/15
 * Time: 21:19
 */

namespace ShuttleCli\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Cache\Repository;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Cache;
use ShuttleCli\Attendance;
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
        $trips = $this->secure->trips();

        uasort($trips, function($a, $b)
        {
            $first = (new Carbon($a->leaves_at))->format('U');
            $second= (new Carbon($b->leaves_at))->format('U');

            if ($first == $second) {
                return 0;
            }

            return ($first < $second) ? -1 : 1;
        });

        return view('shuttle.trips', compact('trips'));
    }

    public function trip($id)
    {
        if ( ! is_numeric($id))
        {
            return redirect('/trips');
        }

        $trip = $this->secure->trip($id);

        $attendances = Attendance::where('trip', $id)->get();

        return view('shuttle.trip', compact('trip', 'attendances'));
    }
}