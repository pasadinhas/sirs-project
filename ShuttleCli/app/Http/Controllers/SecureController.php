<?php

namespace ShuttleCli\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;

use ShuttleCli\Exceptions\Secure\BadNonceException;
use ShuttleCli\Exceptions\Secure\BadStatusCodeException;
use ShuttleCli\Exceptions\Secure\InvalidTimestampException;
use ShuttleCli\Http\Requests;
use ShuttleCli\Http\Controllers\Controller;
use stdClass;

class SecureController extends Controller
{
    private $http;
    private $server;
    private $secure;
    private $encrypter;

    public function __construct(Client $http, Encrypter $encrypter)
    {
        $this->middleware('busdriver', ['except' => 'login']);
        $this->http = $http;
        $this->server = config('server.uri', 'http://localhost:8000');
        $this->secure = $this->server . '/secure';
        $this->encrypter = $encrypter;
    }

    protected function handshake()
    {
        $secure = [
            'timestamp' => microtime(true) * 10000
        ];

        $response = $this->postSecureJson($secure);

        $this->assertValidTimestamp($response->timestamp);

        return $response;
    }

    public function login(Request $request)
    {
        $handshake = $this->handshake();

        $secure = [
            'nonce' => $handshake->nonce + 2,
            'username' => $request->get('username'),
            'password' => $request->get('password'),
            'timestamp' => microtime(true) * 10000,
        ];

        $response = $this->postSecureJson($secure, '/auth');

        $this->assertValidTimestamp($response->timestamp, $handshake->timestamp);
        $this->assertValidNonce($response->nonce, $handshake->nonce);

        if ($response->login == true)
        {
            // Login User !!!!!!!!!
        }
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

    protected function postSecureJson($secure = '', $uri = '')
    {
        $response = $this->http->post($this->secure . $uri, [
            'json' => [
                'id' => 1,
                'secure' => $this->encrypter->encrypt(json_encode($secure)),
            ]
        ]);

        if ($response->getStatusCode() == 200)
        {
            $decrypt = $this->encrypter->decrypt($response->getBody()->getContents());
            return json_decode($decrypt);
        }

        $path = ($uri == '') ? '/' : $uri;
        $code = $response->getStatusCode();

        throw new BadStatusCodeException("Status code {{$code}} posting to '$path'");
    }

    protected function assertValidNonce($nonce, $handshake_nonce)
    {
        if ( ! $nonce == $handshake_nonce + 4)
        {
            throw new BadNonceException("Nonce is $nonce for handshake nonce $handshake_nonce");
        }
    }
}
