<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 02/12/15
 * Time: 15:52
 */

namespace Shuttle\Service;


use Shuttle\Trip;

class SeatsService {

    public function hasSeat(Trip $trip)
    {
        return $this->seats($trip) > 0;
    }

    public function seats(Trip $trip)
    {
        $booked = $trip->passengers()->count();
        $total = $trip->shuttle->seats;
        $lastHour = ($trip->isLastHour()) ? 0 : $this->lastHour($trip);
        return $total - $booked - $lastHour;
    }

    public function lastHour(Trip $trip)
    {
        return round(0.1 * $trip->shuttle->seats);
    }
}