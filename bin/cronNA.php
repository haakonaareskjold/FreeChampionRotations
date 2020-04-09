<?php

use GuzzleHttp\Client;

require_once __DIR__ . "/../src/bootstrap.php";

$key = getenv('API'); // API KEY from .env
if ($key == "API_KEY_HERE" || $key == null) {
    die("Please put your actual API key in the .env file.");
}

$currentTime = new DateTime();
$startTime = new DateTime('Tue 10:59');
$endTime = new DateTime('Tue 11:04');

if (
    $currentTime->format('D H:i:s') >= $startTime->format('D H:i:s')
    && $currentTime->format('D H:i:s') <= $endTime->format('D H:i:s')
) {
    $client = new Client();
    $response = $client->request(
        'GET',
        'https://na1.api.riotgames.com/lol/platform/v3/champion-rotations?api_key=' . $key
    );
    if ($response->getStatusCode() == 200) {
        $fetchBody = $response->getBody();
    }
    $file = dirname(__FILE__) . "/../resources/Cache/rotationNA.json";
    file_put_contents($file, $fetchBody);
}
