<?php

use Illuminate\Support\Facades\Request;

function active($uri)
{
    return \Request::is($uri) ? 'class="active"' : '';
}