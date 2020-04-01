<?php

use GuzzleHttp\Client;

require_once __DIR__ . "/../vendor/autoload.php";

//phpdotenv
$dotenv = Dotenv\Dotenv::createMutable(__DIR__ . "/../");
$dotenv->load();
$dotenv->required(['API', 'PATCH']);

//phpdotenv script to fetch DDragon json to update to newest version automatically
$client = new Client();
$response = $client->request(
    'GET', 
    'http://ddragon.leagueoflegends.com/api/versions.json'
);
$json = $response->getBody();
$array = json_decode($json, true);
$version = $array[0];
putenv("PATCH={$version}");

//misc
date_default_timezone_set('Europe/Berlin'); //sets timezone to UTC+1
