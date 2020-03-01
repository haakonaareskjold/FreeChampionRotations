<?php

require_once __DIR__ . "/../vendor/autoload.php";

use GuzzleHttp\Client;


#TODO
$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'http://httpbin.org',
    // You can set any number of default request options.
    'timeout'  => 2.0,
    ]);