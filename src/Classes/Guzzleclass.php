<?php

namespace App\Classes;

use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\HandlerStack;
use Spatie\GuzzleRateLimiterMiddleware\RateLimiterMiddleware;

class Guzzleclass
{
    private $key;
    private $naStack;
    private $euStack;
    private $id;
    private $content;
    private $guzzle_json;
    private $secondID;
    private $thirdID;
    private const IMG = "https://ddragon.leagueoflegends.com/cdn/10.4.1/img/champion/"; // patch 10.4.1
    private const CHAMPIONS = "http://ddragon.leagueoflegends.com/cdn/10.4.1/data/en_US/champion.json"; // patch 10.4.1

    public function verifyNA()
    {
        $this->key =  getenv('API'); // API KEY from .env
        if ($this->key == "API_KEY_HERE" || $this->key == null) {
            die("<span class=\"httpError\">Please put your actual API key in the .env file.</span>");
        }

        $this->naStack = HandlerStack::create();
        $this->naStack->push(RateLimiterMiddleware::perSecond(3));
        $client = new Client([
            'handler' => $this->naStack,
        ]);

        try {
            $client->request(
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

        
        $this->euStack = HandlerStack::create();
        $this->euStack->push(RateLimiterMiddleware::perSecond(3));
        $client = new Client([
            'handler' => $this->euStack,
        ]);

        try {
            $client->request(
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
            $riotapi = new Client([
            'handler' => $this->euStack,
        ]);
            $response = $riotapi->request(
                'GET',
                'https://euw1.api.riotgames.com/lol/platform/v3/champion-rotations?api_key=' . $this->key
            );
        } elseif (isset($_POST['NA']) || isset($_COOKIE['NA'])) {
            $riotapi = new Client([
                'handler' => $this->naStack,
            ]);
            $response = $riotapi->request(
                'GET',
                'https://na1.api.riotgames.com/lol/platform/v3/champion-rotations?api_key=' . $this->key
            );
        }
        
        

        // Champion V3 REST API
        $this->guzzle_json =  $response->getBody();
        $guzzle_array = json_decode($this->guzzle_json, true);
        $this->id = $guzzle_array['freeChampionIds'];

        //caching
        $currentWeek = date('W', strtotime("- 1 day - 2 hour"));
        $fp = fopen(dirname(__FILE__) . "/../Cache/week-{$currentWeek}.json", "w");
        fwrite($fp, $this->guzzle_json);
        fclose($fp);

        // ddragon JSON
        $ddragon = new Client();
        $res = $ddragon->get(self::CHAMPIONS);
        $ddragon_json = $res->getBody();
        $this->content = json_decode($ddragon_json, true);

        //experimental -
        //supposed to check if its within the given time and then will put id to use latest cache instead of API
        if (isset($_POST['NA']) || isset($_COOKIE['NA'])) {
            $currentTime = new DateTime();
            $startTime = new DateTime('Tue 01:00');
            $endTime = new DateTime('Tue 08:00');

            if (
                $currentTime->format('D H:i:s') >= $startTime->format('D H:i:s') &&
                $currentTime->format('D H:i:s') <= $endTime->format('D H:i:s')
            ) {
                $currentWeek = date('W', strtotime("- 1 day - 2 hour"));
                $previousWeek = $currentWeek - 1;
                $cachedWeek = dirname(__FILE__) . "/../Cache/week-{$previousWeek}.json";
                if (file_exists($cachedWeek)) {
                    $json_array_cache = json_decode(file_get_contents($cachedWeek), true);
                    $this->id = $json_array_cache['freeChampionIds'];
                }
            }
        }
    }

    public function cacheChampions()
    {
        $currentTime = new DateTime();
        $startTime = new DateTime('Tue 01:00');
        $endTime = new DateTime('Tue 08:00');

        if (
            $currentTime->format('D H:i:s') >= $startTime->format('D H:i:s')
            && $currentTime->format('D H:i:s') <= $endTime->format('D H:i:s') && isset($_COOKIE['NA'])
        ) {
            $currentWeek = date('W', strtotime("- 1 day - 2 hour"));
            $previousWeek = $currentWeek - 2;
            $previousWeekTwo = $currentWeek - 3;
        } else {
            $currentWeek = date('W', strtotime("- 1 day - 2 hour"));
            $previousWeek = $currentWeek - 1;
            $previousWeekTwo = $currentWeek - 2;
        }
        $file1 = dirname(__FILE__) . "/../Cache/week-{$previousWeek}.json";
        $file2 = dirname(__FILE__) . "/../Cache/week-{$previousWeekTwo}.json";

        if (file_exists($file1) && file_exists($file2)) {
            $json_array = json_decode(file_get_contents($file1), true);
            $this->secondID = $json_array['freeChampionIds'];

            $json_array_third = json_decode(file_get_contents($file2), true);
            $this->thirdID = $json_array_third['freeChampionIds'];
        }
    }



    public function currentWeek()
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


    public function aramChampions()
    {
        // removing duplicates, checking for diff between the ones fetched from the API and the ones merged
        $result = array_merge($this->secondID, $this->thirdID);
        $aram = array_unique($result);
        $finalresult = array_diff($aram, $this->id);
        

        //echo the data/img out
        foreach ($this->content['data'] as $champ) {
            foreach ($finalresult as $freeid) {
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

    public function clearCache()
    {
        $files = glob(dirname(__FILE__) . '/../Cache/*.json');
        if (count($files) > 5) {
            foreach ($files as $deletefiles) {
                if (time() - filectime($deletefiles) > 10 * 24 * 60 * 60) {
                    unlink($deletefiles);
                }
            }
        }
    }
}