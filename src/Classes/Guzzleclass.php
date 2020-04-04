<?php

namespace App\Classes;

use DateTime;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Twig\Loader\FilesystemLoader;

//mock
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;


class Guzzleclass
{

    private $id;
    private $content;
    private $result;
    private $img;
    private $champions;

    /**
     * @var Environment
     */
    private Environment $twig;
    /**
     * @var array|false|string
     */
    private $key;
    /**
     * @var ResponseInterface
     */
    private ResponseInterface $responseNA;
    /**
     * @var ResponseInterface
     */
    private ResponseInterface $responseEUW;
    /**
     * @var \Psr\Http\Message\StreamInterface
     */
    private \Psr\Http\Message\StreamInterface $euwBody;
    /**
     * @var \Psr\Http\Message\StreamInterface
     */
    private \Psr\Http\Message\StreamInterface $naBody;


    public function testAPI()
    {
        /**
         * check if guzzle can fetch riot API with ENV key
         * then if both NA and EUW has connection without errors
         */

        //API key loading
        $this->key =  getenv('API'); // API KEY from .env
        if ($this->key == "API_KEY_HERE" || $this->key == null) {
            die("<span class=\"httpError\">Please put your actual API key in the .env file.</span>");
        }

        //Twig
        $loader = new FilesystemLoader('../templates');
        $this->twig = new Environment($loader);

        $this->requestEUW();
        $this->requestNA();
        $this->euTimer();
        $this->naTimer();
    }

    private function euTimer()
    {
        $currentTime = new DateTime();
        $startTime = new DateTime('Tue 01:58');
        $endTime = new DateTime('Tue 02:02');

        if ($currentTime->format('D H:i:s') >= $startTime->format('D H:i:s')
            && $currentTime->format('D H:i:s') <= $endTime->format('D H:i:s')) {
            $this->requestEUW();
        }
    }

    private function natimer()
    {
        $currentTime = new DateTime();
        $startTime = new DateTime('Tue 10:58');
        $endTime = new DateTime('Tue 11:02');

        if ($currentTime->format('D H:i:s') >= $startTime->format('D H:i:s')
            && $currentTime->format('D H:i:s') <= $endTime->format('D H:i:s')) {
            $this->requestNA();
        }
    }

    private function requestNA()
    {

        try {
            $client = new Client();
            $this->responseNA = $client->request(
                'GET',
                'https://na1.api.riotgames.com/lol/platform/v3/champion-rotations?api_key=' . $this->key
            );
        } catch (ClientException | ServerException $e) {
            $code = $e->getResponse()->getStatusCode();

            if (
                $code == 400 || $code == 401 || $code == 403 ||
                $code == 404 || $code == 405 || $code == 415 || $code == 429
            ) {
                return ($this->twig->render('error.html.twig',
                    [
                        'error' => 'Client',
                        'code' => $code,
                        'server' => 'NA'
                    ]));
            } elseif ($code == 500 || $code == 502 || $code == 503 || $code == 504) {
                return ($this->twig->render('error.html.twig',
                    [
                        'error' => 'Server',
                        'code' => $code,
                        'server' => 'NA'
                    ]));
            }
        }
        if ($this->responseNA->getStatusCode() == 200) {
            $this->naBody = $this->responseNA->getBody();
        }
        $cache = fopen(dirname(__FILE__) . "/../Cache/rotationNA.json", "w");
        fwrite($cache, $this->naBody);;
        fclose($cache);
        }

    private function requestEUW()
    {


        try {
            $client = new Client();
            $this->responseEUW = $client->request(
                'GET',
                'https://euw1.api.riotgames.com/lol/platform/v3/champion-rotations?api_key=' . $this->key
            );
        } catch (ClientException | ServerException $e) {
            $code = $e->getResponse()->getStatusCode();

            if (
                $code == 400 || $code == 401 || $code == 403 ||
                $code == 404 || $code == 405 || $code == 415 || $code == 429
            ) {
                die ($this->twig->render('error.html.twig',
                    [
                        'error' => 'Client',
                        'code' => $code,
                        'server' => 'EUW'
                    ]));
            } elseif ($code == 500 || $code == 502 || $code == 503 || $code == 504) {
                die ($this->twig->render('error.html.twig',
                    [
                        'error' => 'Server',
                        'code' => $code,
                        'server' => 'EUW'
                    ]));
            }
        }
        if ($this->responseEUW->getStatusCode() == 200) {
            $this->euwBody = $this->responseEUW->getBody();
    }
        $cache = fopen(dirname(__FILE__) . "/../Cache/rotationEUW.json", "w");
        fwrite($cache, $this->euwBody);;
        fclose($cache);
    }


    public function fetchID()
    {
        if (isset($_POST['EUW']) || isset($_COOKIE['EUW'])) {
            $cacheEUW = dirname(__FILE__) . "/../Cache/rotationEUW.json";
            $array = json_decode(file_get_contents($cacheEUW), true);
            $this->id = $array['freeChampionIds'];
        } elseif (isset($_POST['NA']) || isset($_COOKIE['NA'])) {
            $cacheNA = dirname(__FILE__) . "/../Cache/rotationNA.json";
            $array = json_decode(file_get_contents($cacheNA), true);
            $this->id = $array['freeChampionIds'];
        }

        // Data Dragon JSON
        $this->champions = "http://ddragon.leagueoflegends.com/cdn/" . getenv('PATCH') . "/data/en_US/champion.json";
        $ddragon = new Client();
        $res = $ddragon->get($this->champions);
        $ddragon_json = $res->getBody();
        $this->content = json_decode($ddragon_json, true);
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

}