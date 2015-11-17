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
        $secure = $this->encrypter->encrypt(json_encode(['timestamp' => microtime(true) * 10000]));

        $response = $this->http->post($this->secure, ['json' => [
            'id' => 1,
            'secure' => $secure
        ]]);

        if ($response->getStatusCode() == 200)
        {
            return json_decode($response->getBody()->getContents(), );
        }

    }

    public function login()
    {
        $secure = $this->encrypter->encrypt(json_encode(['timestamp' => microtime(true) * 10000]));
        $data = json_encode(['id' => 1, 'secure' => $secure]);

        //dd($data);

        $response = $this->http->post($this->secure, ['json' => ['id' => 1, 'secure' => $secure]]);

        dd($response->getBody()->getContents());

        // Send secure request request
        // Send secure auth request
        // validade server response
    }

    public function foo()
    {
        dd('t');
    }
}
