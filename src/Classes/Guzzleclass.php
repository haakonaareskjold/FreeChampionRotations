<?php

namespace App\Classes;

use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class Guzzleclass
{
    private $key;
    private $id;
    private $content;
    private const IMG = "https://ddragon.leagueoflegends.com/cdn/10.4.1/img/champion/"; // patch 10.4.1
    private const CHAMPIONS = "http://ddragon.leagueoflegends.com/cdn/10.4.1/data/en_US/champion.json"; // patch 10.4.1

    public function verifyNA()
    {
        $this->key =  getenv('API'); // API KEY from .env
        if ($this->key == "API_KEY_HERE" || $this->key == null) {
            die("<span class=\"httpError\">Please put your actual API key in the .env file.</span>");
        }

        $client = new Client();
        try {
            $reponse = $client->request(
                'GET',
                'https://na1.api.riotgames.com/lol/platform/v3/champion-rotations?api_key=' . $this->key
            );
        } catch (ClientException | ServerException $e) {
            $code = $e->getResponse()->getStatusCode();

            if (
                $code == 400 || $code == 401 || $code == 403 ||
                $code == 404 || $code == 405 || $code == 415 || $code == 429
            ) {
                die("<span class=\"httpError\">A client error has occured, please try again later.</span>");
            } elseif ($code == 500 || $code == 502 || $code == 503 || $code == 504) {
                die("<span class=\"httpError\">A server error has occured, please try again later.</span>");
            }
        }
    }

    public function verifyEUW()
    {
        $this->key =  getenv('API'); // API KEY from .env
        if ($this->key == "API_KEY_HERE" || $this->key == null) {
            die("<span class=\"httpError\">Please put your actual API key in the .env file.</span>");
        }

        $client = new Client();
        try {
            $reponse = $client->request(
                'GET',
                'https://euw1.api.riotgames.com/lol/platform/v3/champion-rotations?api_key=' . $this->key
            );
        } catch (ClientException | ServerException $e) {
            $code = $e->getResponse()->getStatusCode();

            if (
                $code == 400 || $code == 401 || $code == 403 ||
                $code == 404 || $code == 405 || $code == 415 || $code == 429
            ) {
                die("<span class=\"httpError\">Client error [4xx] has appeared, please try again later.</span>");
            } elseif ($code == 500 || $code == 502 || $code == 503 || $code == 504) {
                die("<span class=\"httpError\">Server error [5xx] has appeared, please try again later.</span>");
            }
        }
    }


    

    public function fetchID()
    {
        $this->key =  getenv('API'); // API KEY from .env

        if (isset($_POST['EUW']) || isset($_COOKIE['EUW'])) {
            // V3 champion rotation API
            $riotapi = new Client();
            $response = $riotapi->request(
                'GET',
                'https://euw1.api.riotgames.com/lol/platform/v3/champion-rotations?api_key=' . $this->key
            );
        } elseif (isset($_POST['NA']) || isset($_COOKIE['NA'])) {
            $riotapi = new Client();
            $response = $riotapi->request(
                'GET',
                'https://na1.api.riotgames.com/lol/platform/v3/champion-rotations?api_key=' . $this->key
            );
        }

        // Champion V3 REST API
        #TODO - error 500 IF cookie has not been created
        $guzzle_json =  $response->getBody();
        $guzzle_array = json_decode($guzzle_json, true);
        $this->id = $guzzle_array['freeChampionIds'];

        //caching
        $currentWeek = date('W');
        $fp = fopen(dirname(__FILE__) . "/../Cache/week-{$currentWeek}.json", "w+");
        fwrite($fp, $guzzle_json);
        fclose($fp);

        // ddragon JSON
        $ddragon = new Client();
        $res = $ddragon->get(self::CHAMPIONS);
        $ddragon_json = $res->getBody();
        $this->content = json_decode($ddragon_json, true);
    }



    public function guzzleResults()
    {
        foreach ($this->content['data'] as $champ) {
            foreach ($this->id as $freeid) {
                if ($champ["key"] == $freeid) {
                    $displayImg = self::IMG . $champ["id"] . ".png"; ?>
                    <div class="item">
                        <?php
                        echo '<img src="' . $displayImg . '">';
                        ?>
                        <span class="caption"><?php echo $champ['id']; ?></span>
                    </div><?php
                }
            }
        }
    }

    public function serverCheck()
    {
        if (isset($_POST['EUW']) || isset($_COOKIE["EUW"])) {
            echo 'EUW';
        } elseif (isset($_POST['NA']) || isset($_COOKIE['NA'])) {
            echo 'NA';
        }
    }
}
