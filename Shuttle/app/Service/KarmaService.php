<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 02/12/15
 * Time: 15:53
 */

namespace Shuttle\Service;


use Carbon\Carbon;
use Shuttle\Booking;
use Shuttle\Trip;
use Shuttle\User;

class KarmaService
{

    function __construct()
    {
    }

    public function bonus(User $user)
    {
        return $user->karma * 5;
    }

    public function cancelReservation(User $user, Trip $trip)
    {
        $now = new Carbon();
        $departure = new Carbon($trip->leaves_at);
        $reservation = Booking::where('user_id', $user->id)->where('trip_id', $trip->id)->first();
        $reservationTime = new Carbon($reservation->created_at);

        $percent = $now->diffInMinutes($reservationTime) / $departure->diffInMinutes($reservationTime);

        $karma = round(1 + pow(pow(47, 1/3) * $percent,3));

        $user->karma = $user->karma - $karma;

        $user->save();
    }

    public function checkin(User $user)
    {
        $user->karma = $user->karma + 12; // 1 hour
        $user->save();
    }

    public function miss(User $user)
    {
        $user->karma = $user->karma - 60;
        $user->save();
    }
}