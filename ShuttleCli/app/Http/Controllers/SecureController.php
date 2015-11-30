<?php

namespace ShuttleCli\Http\Controllers;

use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;

use ShuttleCli\Http\Requests;
use ShuttleCli\Services\SecureService;

class SecureController extends Controller
{
    private $server;
    private $secure;
    private $service;

    public function __construct(Encrypter $encrypter)
    {
        $this->middleware('busdriver', ['except' => 'login']);
        $this->service = new SecureService($encrypter);
    }

    public function login(Request $request)
    {
        $response = $this->service->login($request);

        dd($response);
        if ($response->login == true)
        {
            // Login User !!!!!!!!!
        }
    }


}
