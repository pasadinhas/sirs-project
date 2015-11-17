<?php

namespace ShuttleCli\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;

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

    private function askForRequest()
    {
        $secure = ['timestamp' => microtime(true) * 10000];
        $encrypted = $this->encrypter->encrypt(json_encode($secure));

        $response = $this->http->post($this->secure, [
            'json' => [
                'id' => 1,
                'secure' => $encrypted
            ]
        ]);

        if ($response->getStatusCode() == 200)
        {
            $decrypt = $this->encrypter->decrypt($response->getBody()->getContents());
            return json_decode($decrypt);
        }

        throw new \Exception("Login - not 200 response - Error code " . $response->getStatusCode());
    }

    public function login(Request $request)
    {
        $response = $this->askForRequest();

        $secure = [
            'nonce' => $response->nonce + 2,
            'username' => $request->get('username'),
            'password' => $request->get('password'),
            'timestamp' => microtime(true) * 10000,
        ];

        $encrypted = $this->encrypter->encrypt(json_encode($secure));

        $resp = $this->http->post($this->secure . '/auth', [
            'json' => [
                'id' => 1,
                'secure' => $encrypted,
            ]
        ]);

        dd(json_decode($resp->getBody()->getContents()));

        // validade server response
    }

    public function foo()
    {
        dd('t');
    }
}
