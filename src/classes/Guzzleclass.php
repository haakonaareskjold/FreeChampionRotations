<?php

namespace App\Classes;

use GuzzleHttp\Client;

class Guzzleclass
{
    private $id;
    private $content;
    private const IMG = "https://ddragon.leagueoflegends.com/cdn/10.4.1/img/champion/";

    public function fetchID()
    {
        // V3 champion rotation API
        if (isset($_GET['Location'])) {
        $riotapi = new Client();
        $response = $riotapi->request('GET', 'https://euw1.api.riotgames.com/lol/platform/v3/champion-rotations?api_key=' . $_GET['key']);
    } else {
        $riotapi = new Client();
        $response = $riotapi->request('GET', 'https://na1.api.riotgames.com/lol/platform/v3/champion-rotations?api_key=' . $_GET['key']);
    }
        // Champion V3 REST API
        $guzzle_json =  $response->getBody();
        $guzzle_array = json_decode($guzzle_json, true);
        $this->id = $guzzle_array['freeChampionIds'];

        // ddragon JSON
        $ddragon = new Client();
        $res = $ddragon->get('http://ddragon.leagueoflegends.com/cdn/9.3.1/data/en_US/champion.json');
        $ddragon_json = $res->getBody();
        $this->content = json_decode($ddragon_json, true);
    }

    public function guzzleResults()
    {
        foreach ($this->content['data'] as $champ) {
            foreach ($this->id as $freeid) {
                if ($champ["key"] == $freeid) {
                    $displayImg = self::IMG . $champ["id"] . ".png";
                    echo '<img src="'.$displayImg.'">';
                }
            }
        }
    }

    public function serverCheck()
    {
        $url =  $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

        if (strpos($url,'EUW') == true) {
            echo 'EUW';
        } else {
            echo 'NA';
        }
    }

}