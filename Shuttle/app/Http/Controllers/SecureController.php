<?php

namespace Shuttle\Http\Controllers;

use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Shuttle\Exceptions\Secure\BadRequestDataException;
use Shuttle\Exceptions\Secure\BadRequestSchemaException;
use Shuttle\Exceptions\Secure\InvalidTimestampException;
use Shuttle\Exceptions\Secure\LoginException;
use Shuttle\Http\Requests;
use Illuminate\Cache\Repository as Cache;
use Shuttle\Shuttle;

class SecureController extends Controller
{
    private $crypter = null;

    public function __construct()
    {
    }

    /*
    |--------------------------------------------------------------------------
    | Public API
    |--------------------------------------------------------------------------
    |
    | This are the methods responsible for handling the secure API calls
    |
    */

    public function authHandshake(Request $request, Cache $cache)
    {
        list($name, $data) = $this->parseSecureRequest($request, ['timestamp']);

        $timestamp = $data->timestamp;

        $this->assertValidTimestamp($timestamp);

        $now = intval(microtime(true) * 10000);
        $nonce = $this->generateNonce();

        $cache->put("shuttle.$name.login", true, 1);
        $cache->put("shuttle.$name.nonce", $nonce, 1);
        $cache->put("shuttle.$name.timestamp", $timestamp, 1);

        $response = [
            'nonce' => $nonce,
            'timestamp' => $now,
        ];

        return $this->secureResponseJson($response);
    }

    public function handshake(Request $request, Cache $cache)
    {
        list($name, $data) = $this->parseSecureRequest($request, ['timestamp']);

        $timestamp = $data->timestamp;

        $this->assertValidTimestamp($timestamp);

        $now = intval(microtime(true) * 10000);
        $nonce = $this->generateNonce();

        $cache->put("shuttle.$name.nonce", $nonce, 1);
        $cache->put("shuttle.$name.timestamp", $timestamp, 1);

        $response = [
            'nonce' => $nonce,
            'timestamp' => $now,
        ];

        return $this->secureResponseJson($response);
    }

    public function auth(Request $request, Cache $cache)
    {
        list($name, $data) = $this->parseSecureRequest($request, ['nonce', 'username', 'password', 'timestamp']);

        $this->assertValidTimestamp($data->timestamp, $cache->get("shuttle.$name.timestamp"));
        $this->assertValidNonce($data->nonce, $cache->get("shuttle.$name.nonce"));

        $result = Auth::once(['username' => $data->username, 'password' => $data->password]);

        if ($result !== true)
        {
            throw new LoginException("Logging in user: {$data->username}");
        }

        // Generate session key
        $key = Str::random(32);
        $cache->put("shuttle.$name.key", $key, 60*8);

        $user = Auth::user();

        $response = [
            'username' => $user->username,
            'email' => $user->email,
            'nonce' => $data->nonce + 2,
            'timestamp' => microtime(true) * 10000,
            'key' => $key,
        ];

        return $this->secureResponseJson($response);
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



    protected function parseSecureRequest(Request $request, $keys = [])
    {
        if ( ! $request->has('id') || ! $request->has('secure'))
        {
            throw new BadRequestSchemaException();
        }

        $name = $request->get('id');
        $secure = $request->get('secure');

        $shuttle = Shuttle::where('name', $name)->first();

        if ( ! $shuttle)
        {
            throw new BadRequestDataException("Shuttle $name does not exist");
        }

        $crypter = $this->getCrypter($shuttle->key);

        $decrypted = $crypter->decrypt($secure);
        $json = json_decode($decrypted);

        foreach ($keys as $key)
        {
            if ( ! isset($json->$key))
            {
                throw new BadRequestSchemaException("Secure should have key $key");
            }
        }

        return [$name, $json];
    }

    protected function assertValidTimestamp($timestamp, $previous = null)
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

    /**
     * @return int
     */
    public function generateNonce()
    {
        return mt_rand(1, 4294967296 - 4);
    }

    private function secureResponseJson($response)
    {
        return $this->getCrypter()->encrypt(json_encode($response));
    }

    private function assertValidNonce($nonce, $handshake_nonce)
    {
        return $nonce == $handshake_nonce + 2;
    }
}