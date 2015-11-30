<?php

namespace ShuttleCli\Services;

use GuzzleHttp\Client;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Encryption\Encrypter as EncrypterClass;
use Illuminate\Support\Facades\Cache;
use ShuttleCli\Exceptions\Secure\InvalidTimestampException;
use Illuminate\Http\Request;

class SecureService
{

    private $http;
    private $encrypter;
    private $validate;
    private $server;
    private $uri;

    function __construct(Encrypter $encrypter)
    {
        $this->http = new Client();
        $this->encrypter = $encrypter;
        $this->validate = new ValidatorService();
        $this->server = config('server.uri', 'http://localhost:8000');
        $this->uri = $this->server . '/secure';
    }


    // +-----------------------------
    // | Public API
    // +-----------------------------


    public function handshake($auth = false)
    {
        $secure = [
            'timestamp' => microtime(true) * 10000
        ];

        $response = $this->postSecureJson($secure, ($auth) ? '/auth' : '');

        $this->validate->timestamp($response->timestamp);

        return $response;
    }

    public function login(Request $request)
    {
        $response = $this->request('/auth', [
            'username' => $request->get('username'),
            'password' => $request->get('password'),
        ]);

        Cache::put('session.key', $response->key, 8*60); // key lasts 8 hours max

        return $response;
    }

    public function trips()
    {
        return $this->sessionRequest('/trips');
    }

    public function trip($id)
    {
        return $this->sessionRequest('/trip', ['id' => $id]);
    }

    // +-----------------------------
    // | Protected Methods
    // +-----------------------------

    protected function sessionRequest($uri, $data = [])
    {
        $this->session();
        return $this->request($uri, $data);
    }

    protected function request($uri, $data = [])
    {
        $handshake = $this->handshake();

        $secure = [
            'nonce' => $handshake->nonce + 2,
            'timestamp' => microtime(true) * 10000,
        ];

        $secure = array_merge($secure, $data);

        $response = $this->postSecureJson($secure, $uri);

        $this->validate->timestamp($response->timestamp, $handshake->timestamp);
        $this->validate->nonce($response->nonce, $handshake->nonce);

        return $response;
    }

    protected function session()
    {
        $key = Cache::get('session.key');

        if ($key == null)
        {
            // TODO: oops
        }

        $this->encrypter = new EncrypterClass($key, 'AES-256-CBC');

        return $key;
    }

    protected function postSecureJson($secure = '', $uri = '')
    {
        $response = $this->http->post($this->uri . $uri, [
            'json' => [
                'id' => config('shuttle.id', 'S01'),
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


}