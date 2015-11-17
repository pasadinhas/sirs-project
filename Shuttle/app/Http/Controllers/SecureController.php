<?php

namespace Shuttle\Http\Controllers;

use Illuminate\Http\Request;

use Shuttle\Http\Requests;
use Shuttle\Http\Controllers\Controller;

class SecureController extends Controller
{
    public function getIndex()
    {
        return 2;
    }
}