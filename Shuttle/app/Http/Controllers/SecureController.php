<?php

namespace Shuttle\Http\Controllers;

use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Shuttle\Exceptions\NoSecureLoginException;
use Shuttle\Exceptions\Secure\BadRequestDataException;
use Shuttle\Exceptions\Secure\BadRequestSchemaException;
use Shuttle\Exceptions\Secure\InvalidTimestampException;
use Shuttle\Exceptions\Secure\LoginException;
use Shuttle\Http\Requests;
use Illuminate\Cache\Repository as Cache;
use Shuttle\Service\BookingService;
use Shuttle\Shuttle;
use Shuttle\Trip;
use Shuttle\User;

class SecureController extends Controller
{
    private $crypter = null;
    private $shuttle = null;
    private $cache = null;
    private $nonce = null;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /*
    |--------------------------------------------------------------------------
    | Public API
    |--------------------------------------------------------------------------
    |
    | This are the methods responsible for handling the secure API calls
    |
    */


    public function auth(Request $request)
    {
        $data = $this->validateRequest($request, ['username', 'password'], true);

        $result = Auth::once(['username' => $data->username, 'password' => $data->password]);

        if ($result !== true || ! Auth::user()->isDriver())
        {
            throw new LoginException("Logging in user: {$data->username}");
        }

        // Generate session key
        $key = Str::random(32);
        $this->cache->put("shuttle.{$this->shuttle->name}.key", $key, 60*8);
        $this->cache->put("shuttle.{$this->shuttle->name}.user", Auth::user(), 60*8);

        return $this->encryptJson(['key' => $key]);
    }

    public function trips(Request $request)
    {
        $this->validateRequest($request);
        $user = $this->cache->get("shuttle.{$this->shuttle->name}.user");
        $trips = $this->shuttle->trips()
            ->where('driver_id', $user->id)
            ->future()
            ->get();
        return $this->encryptJson(['trips' => $trips->toArray()]);
    }

    public function trip(Request $request)
    {
        $data = $this->validateRequest($request, ['id']);
        $user = $this->cache->get("shuttle.{$this->shuttle->name}.user");
        $trips = $this->shuttle->trips()
            ->where('id', $data->id)
            ->where('driver_id', $user->id)
            ->future()
            ->with('passengers')
            ->first();
        return $this->encryptJson(['trip' => $trips->toArray()]);
    }

    public function checkin(Request $request)
    {
        $data = $this->validateRequest($request, ['id', 'attendances']);

        $service = new BookingService();

        foreach ($data->attendances as $attendance)
        {
            if ($attendance->user && $attendance->trip && $attendance->trip == $data->id)
            {
                $user = User::find($attendance->user);
                $trip = Trip::find($attendance->trip);

                if ($user && $trip)
                {
                    $service->checkin($user, $trip);
                }
            }
        }

        $service->markMissing($trip);

        return $this->encryptJson([]);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    |
    | This are the methods that support the controller functionality.
    | They should totally be extracted to a dedicated service.
    |
    */

    public function getCrypter($key = null)
    {
        if ($key != null)
        {
            $this->crypter = new Encrypter($key, 'AES-256-CBC');
        }
        return $this->crypter;
    }



    protected function validateRequest(Request $request, $keys = [], $kek = false)
    {
        if ( ! $request->has('id') || ! $request->has('secure'))
        {
            throw new BadRequestSchemaException();
        }

        $name = $request->get('id');
        $secure = $request->get('secure');

        $shuttle = $this->findShuttle($name);

        if ( ! $kek)
        {
            // must exist a session
            if ( ! $this->cache->has("shuttle.{$this->shuttle->name}.key")
                || ! $this->cache->has("shuttle.{$this->shuttle->name}.user"))
            {
                throw new NoSecureLoginException();
            }
        }

        $crypter = $this->chooseEncrypter($kek, $shuttle);

        $decrypted = $crypter->decrypt($secure);
        $json = json_decode($decrypted);

        $keys = array_merge($keys, ['timestamp', 'nonce']);

        foreach ($keys as $key)
        {
            if ( ! isset($json->$key))
            {
                throw new BadRequestSchemaException("Secure should have key $key");
            }
        }

        $this->assertValidTimestamp($json->timestamp, $shuttle->name);
        $this->nonce = $json->nonce;
        return $json;
    }

    protected function assertValidTimestamp($timestamp, $name)
    {
        $previousTimestamp = $this->cache->get("shuttle.$name.timestamp");

        if ( ! $this->validTimestamp($timestamp, $previousTimestamp))
        {
            throw new InvalidTimestampException("Timestamp {{$timestamp}} is not valid now.");
        }

        $this->cache->forever("shuttle.$name.timestamp", $timestamp);
    }

    protected function validTimestamp($timestamp, $previous = null)
    {
        $MAX_DELAY = 10 * 10000; // 10 seconds
        $now = microtime(true) * 10000;
        // TODO: this should be > and not >= . It's >= for debug.
        return ($previous ? $timestamp >= $previous : true) && $timestamp > $now - $MAX_DELAY && $timestamp < $now + $MAX_DELAY;
    }

    private function encryptJson($response)
    {
        $response = array_merge($response, [
            'nonce' => $this->nonce + 2,
            'timestamp' => microtime(true) * 10000,
        ]);

        return $this->getCrypter()->encrypt(json_encode($response));
    }

    /**
     * @param $name
     * @return mixed
     * @throws BadRequestDataException
     */
    protected function findShuttle($name)
    {
        $shuttle = Shuttle::where('name', $name)->first();

        if (!$shuttle) {
            throw new BadRequestDataException("Shuttle $name does not exist");
        }

        $this->shuttle = $shuttle;
        return $shuttle;
    }

    /**
     * @param $kek
     * @param $shuttle
     * @return array
     */
    protected function chooseEncrypter($kek, $shuttle)
    {
        $key = ($kek) ? $shuttle->key : $this->cache->get("shuttle.{$shuttle->name}.key");
        $this->crypter = new Encrypter($key, 'AES-256-CBC');
        return $this->crypter;
    }
}