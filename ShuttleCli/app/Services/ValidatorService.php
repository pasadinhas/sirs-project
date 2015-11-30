<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 28/11/15
 * Time: 20:31
 */

namespace ShuttleCli\Services;


class ValidatorService {

    public function timestamp($timestamp, $previous = null)
    {
        if ( ! $this->validateTimestamp($timestamp, $previous))
        {
            throw new InvalidTimestampException("Timestamp {{$timestamp}} is not valid at this time");
        }
    }

    protected function validateTimestamp($timestamp, $previous = null)
    {
        $MAX_DELAY = 10 * 10000; // 10 seconds
        $now = microtime(true) * 10000;
        return ($previous ? $timestamp > $previous : true) && $timestamp > $now - $MAX_DELAY && $timestamp < $now + $MAX_DELAY;
    }


    public function nonce($nonce, $handshake_nonce)
    {
        if ( ! $nonce == $handshake_nonce + 4)
        {
            throw new BadNonceException("Nonce is $nonce for handshake nonce $handshake_nonce");
        }
    }
}