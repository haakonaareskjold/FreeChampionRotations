<?php

namespace App\Classes;

use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\HandlerStack;
use Spatie\GuzzleRateLimiterMiddleware\RateLimiterMiddleware;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Guzzleclass
{
    private $key;
    private $twig;
    private $naStack;
    private $euStack;
    private $id;
    private $content;
    private $result;
    private $guzzle_json;
    private $secondID;
    private $thirdID;
    private $img;
    private $champions;

    public function verifyNA()
    {
        $this->key =  getenv('API'); // API KEY from .env
        if ($this->key == "API_KEY_HERE" || $this->key == null) {
            die("<span class=\"httpError\">Please put your actual API key in the .env file.</span>");
        }

        //Twig
        $loader = new FilesystemLoader('../templates');
        $this->twig = new Environment($loader);

        //Guzzle middleware RateLimiter
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
                die($this->twig->render('baseClientError.html'));
            } elseif ($code == 500 || $code == 502 || $code == 503 || $code == 504) {
                die($this->twig->render('baseServerError.html'));
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
                die($this->twig->render('baseClientError.html'));
            } elseif ($code == 500 || $code == 502 || $code == 503 || $code == 504) {
                die($this->twig->render('baseServerError.html'));
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
        $this->champions = "http://ddragon.leagueoflegends.com/cdn/" . getenv('PATCH') . "/data/en_US/champion.json";
        $ddragon = new Client();
        $res = $ddragon->get($this->champions);
        $ddragon_json = $res->getBody();
        $this->content = json_decode($ddragon_json, true);

        if (isset($_POST['NA']) || isset($_COOKIE['NA'])) {
            $currentTime = new DateTime();
            $startTime = new DateTime('Tue 02:00');
            $endTime = new DateTime('Tue 11:00'); //replace with 10:00 if no DST

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
        $startTime = new DateTime('Tue 02:00');
        $endTime = new DateTime('Tue 11:00'); //replace with 10:00 if no DST

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
        $this->img = "https://ddragon.leagueoflegends.com/cdn/" . getenv('PATCH') . "/img/champion/";
        foreach ($this->content['data'] as $champ) {
            foreach ($this->id as $freeid) {
                if ($champ["key"] == $freeid) {
                    $displayImg = $this->img . $champ["id"] . ".png"; ?>
                    <div class="item">
                        <?php
                        print_r("<a href=https://euw.op.gg/champion/{$champ['id']}/statistics/ target=_blank>
                        <img src={$displayImg}></a>");
                        ?>
                        <span class="caption"><?php echo $champ['name']; ?></span>
                    </div><?php
                }
            }
        }
    }


    public function aramChampions()
    {
        $json = dirname(__FILE__) . "/../alwaysaram.json";
        if (file_exists($json)) {
            $json_array = json_decode(file_get_contents($json), true);
            $this->result = $json_array['always'];
        }

        // removing duplicates, checking for diff between the ones fetched from the API and the ones merged
        $aramonly = array_merge($this->id, $this->result);
        $aram = array_unique($aramonly);
        $finalresult = array_diff($aram, $this->id);

        //prints champion name/img
        foreach ($this->content['data'] as $champ) {
            foreach ($finalresult as $freeid) {
                if ($champ["key"] == $freeid) {
                    $displayImg = $this->img . $champ["id"] . ".png"; ?>
                    <div class="item">
                    <?php
                    print_r("<a href=https://euw.op.gg/champion/{$champ['id']}/statistics/ target=_blank>
                        <img src={$displayImg}></a>");
                    ?>
                    <span class="caption"><?php echo $champ['name']; ?></span>
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