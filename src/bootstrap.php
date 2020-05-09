<?php

use GuzzleHttp\Client;

require_once __DIR__ . "/../vendor/autoload.php";

#TODO
# move this logic into guzzleclass , make a cache out of the datadragon API, can be checked every 6th hour
//phpdotenv
$dotenv = Dotenv\Dotenv::createMutable(__DIR__ . "/../");
$dotenv->load();
$dotenv->required(['API', 'PATCH', 'IP']);

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
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//ini_set('error_reporting', E_ALL);
//ini_set('log_errors', 1);
