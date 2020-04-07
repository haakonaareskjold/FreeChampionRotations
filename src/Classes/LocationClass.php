<?php

namespace App\Classes;

use GuzzleHttp\Client;

class LocationClass
{
    private $ip;
    public $location;


    public function noCookies()
    {
        if (!isset($_COOKIE["EUW"]) || !isset($_COOKIE["NA"])) {
            $this->getIP();
            $this->fetch();
            $this->pickServer();
            $this->geoLocation();
        }
    }

    private function getIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $this->ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $this->ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $this->ip = $_SERVER['REMOTE_ADDR'];
        }
        return $this->ip;
    }

    private function fetch()
    {
        //If IP is localhost or nothing submitted - then will fetch your external IP and use that
        if ($this->ip === "127.0.0.1") {
            $this->ip = getenv('IP');
            if (getenv('IP') == null) {
                $externalContent = file_get_contents('http://checkip.dyndns.com/');
                preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
                $externalIp = $m[1];
                $this->ip = $externalIp;
            }
        }

        $locate = new Client();
        $response = $locate->request('GET', "https://api.ipgeolocationapi.com/geolocate/" . $this->ip);
        $json =  $response->getBody();
        $arr = json_decode($json, true);
        $this->location = $arr['continent'];
    }

    public function pickServer()
    {
        if (isset($_POST['EUW'])) {
            $value = 'NA';
            setcookie('NA', $value, strtotime('-30 days'));
            $value = 'EUW';
            setcookie('EUW', $value, strtotime('+30 days'));
            header("refresh:0");
        } elseif (isset($_POST['NA'])) {
            $value = 'EUW';
            setcookie('EUW', $value, strtotime('-30 days'));
            $value = 'NA';
            setcookie('NA', $value, strtotime('+30 days'));
            header("refresh:0");
        }
    }

        
    private function geoLocation()
    {
        if (isset($_COOKIE["EUW"]) || isset($_COOKIE["NA"])) {
            return 0;
        } else {
            if ($this->location === "Europe") {
                $value = 'NA';
                setcookie('NA', $value, strtotime('-30 days'));
                $value = 'EUW';
                setcookie('EUW', $value, strtotime('+30 days'));
                header("refresh:0");
            } elseif ($this->location === "North America") {
                $value = 'EUW';
                setcookie('EUW', $value, strtotime('-30 days'));
                $value = 'NA';
                setcookie('NA', $value, strtotime('+30 days'));
                header("refresh:0");
            } elseif (empty($_COOKIE)) {
                ?>
            <br>
            <h1><span class="error">Can't locate if NA or EU, please pick a server manually</span></h1>
            <br>
                <?php
            }
        }
    }
}