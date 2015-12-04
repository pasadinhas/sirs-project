<?php

namespace ShuttleCli\Services;

use GuzzleHttp\Client;
use Illuminate\Cache\Repository;
use Illuminate\Encryption\Encrypter;
use ShuttleCli\Exceptions\Secure\BadStatusCodeException;
use Illuminate\Http\Request;

class SecureService
{

    private $http;
    private $encrypter;
    private $validate;
    private $server;
    private $uri;
    private $cache;

    function __construct(Encrypter $encrypter, Repository $cache)
    {
        if (config('app.shuttle') == null)
        {
            die('No shuttle configured.');
        }

        if (config('app.server') == null)
        {
            die('No server url configured.');
        }

        $this->cache = $cache;
        $this->http = new Client();
        $this->encrypter = $encrypter;
        $this->validate = new ValidatorService();
        $this->server = config('app.server');
        $this->uri = $this->server . '/secure';
    }


    // +-----------------------------
    // | Public API
    // +-----------------------------

    public function login(Request $request)
    {
        $response = $this->request('/auth', [
            'username' => $request->get('username'),
            'password' => $request->get('password'),
        ]);

        $this->cache->put('session.key', $response->key, 8*60); // key lasts 8 hours max

        return $response;
    }

    public function trips()
    {
        return $this->sessionRequest('/trips')->trips;
    }

    public function trip($id)
    {
        return $this->sessionRequest('/trip', ['id' => $id])->trip;
    }

    public function send($attendances, $trip)
    {
        return $this->sessionRequest('/checkin', [
            'id' => $trip,
            'attendances' => $attendances
        ]);
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
        $secure = [
            'nonce' => mt_rand(1, 4294967290),
            'timestamp' => microtime(true) * 10000,
        ];

        $secure = array_merge($secure, $data);

        $response = $this->postSecureJson($secure, $uri);

        $this->validate->timestamp($response->timestamp, $secure['timestamp']);
        $this->validate->nonce($response->nonce, $secure['nonce']);

        return $response;
    }

    protected function session()
    {
        $key = $this->cache->get('session.key');

        if ($key == null)
        {
            // TODO: oops
        }

        $this->encrypter = new Encrypter($key, 'AES-256-CBC');

        return $key;
    }

    protected function postSecureJson($secure = '', $uri = '')
    {
        $response = $this->http->post($this->uri . $uri, [
            'json' => [
                'id' => config('app.shuttle'),
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