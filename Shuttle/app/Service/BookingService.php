<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 02/12/15
 * Time: 15:51
 */

namespace Shuttle\Service;


use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Shuttle\Exceptions\CannotBookYetException;
use Shuttle\Exceptions\ShuttleIsFullException;
use Shuttle\Trip;
use Shuttle\User;

class BookingService
{

    private $karmaService;
    private $seatsService;
    const BOOKING_TIME = 720; // 12 * 60 => 12 hours

    function __construct()
    {
        $this->karmaService = new KarmaService();
        $this->seatsService = new SeatsService();
    }

    public function book(User $user, Trip $trip)
    {
        if ($trip->passengers->contains($user))
        {

        }

        if ( ! $this->canReserveNow($user, $trip))
        {
            throw new CannotBookYetException();
        }

        if ( ! $this->seatsService->hasSeat($trip))
        {
            throw new ShuttleIsFullException();
        }

        $trip->passengers()->attach($user->id);
    }

    public function cancel(User $user, Trip $trip)
    {
        if ( ! $trip->passengers->contains($user))
        {
            throw new \Exception();
        }

        $departure = new Carbon($trip->leaves_at);
        if ( ! $departure->isFuture())
        {
            throw new \Exception();
        }

        $this->karmaService->cancelReservation($user, $trip);

        $trip->passengers()->detach(Auth::user()->id);
    }

    public function checkin(User $user, Trip $trip)
    {

    }

    public function missed(User $user, Trip $trip)
    {

    }

    public function canReserveNow(User $user, Trip $trip)
    {
        $bonus = $this->karmaService->bonus($user);
        $departure = new Carbon($trip->leaves_at);
        $canReserveAt = $departure->subMinutes(self::BOOKING_TIME + $bonus);
        return ! $canReserveAt->isFuture();
    }
}