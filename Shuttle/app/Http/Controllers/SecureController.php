<?php

namespace Shuttle\Http\Controllers;

use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;
use Shuttle\Http\Requests;
use Illuminate\Cache\Repository as Cache;

class SecureController extends Controller
{
    public function __construct()
    {
    }

    public function getCrypter()
    {
        return new Encrypter('22222222222222222222222222222222', 'AES-256-CBC');
    }

    public function getIndex()
    {
        return 2;
    }

    public function postIndex(Request $request, Cache $cache)
    {
        $crypter = $this->getCrypter();

        $id = $request->get('id');
        $secure = $request->get('secure');
        $decrypted = $crypter->decrypt($secure);
        $json = json_decode($decrypted);
        $timestamp = $json->timestamp;

        $time = intval(microtime(true) * 10000);
        $nonce = mt_rand(1, 4294967296 - 4); // Max int 32 bits - 4

        $cache->put("shuttle.$id.nonce", $nonce, 1);
        $cache->put("shuttle.$id.timestamp", $timestamp, 1);

        $response = [
            'nonce' => $nonce,
            'timestamp' => $timestamp,
        ];

        return $crypter->encrypt(json_encode($response));
    }

    public function postAuth(Request $request, Cache $cache)
    {
        $crypter = $this->getCrypter();

        $id = $request->get('id');
        $secure = $request->get('secure');
        $decrypted = $crypter->decrypt($secure);
        $json = json_decode($decrypted);
        $timestamp = $json->timestamp;
        $username = $json->username;
        $password = $json->password;
        $nonce = $json->nonce;

        return [
            'username' => $username,
            'password' => $password,
            'nonce.check' => $cache->get('shuttle.1.nonce') + 2 == $nonce,
        ];
    }
}