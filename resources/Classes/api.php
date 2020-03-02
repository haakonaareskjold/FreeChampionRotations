<?php

namespace App\Classes;

class Api
{
    protected $id;
    protected $ddragon_array;
    protected $freechampions;
    protected const EUW_SERVER = "https://euw1.api.riotgames.com/";
    protected const NA_SERVER = "https://na1.api.riotgames.com/";
    protected const IMG = "https://ddragon.leagueoflegends.com/cdn/10.4.1/img/champion/";
    

    public function fetchID()
    {

        if (isset($_GET['Location'])) {
            $this->freechampions = self::EUW_SERVER . 'lol/platform/v3/champion-rotations?api_key=' . $_GET['key'];
        } else {
            $this->freechampions = self::NA_SERVER . 'lol/platform/v3/champion-rotations?api_key=' . $_GET['key'];
        }
        $champions_json = file_get_contents($this->freechampions);
        $champions_array = json_decode($champions_json, true);
        $this->id = $champions_array['freeChampionIds'];

        $ddragon = 'http://ddragon.leagueoflegends.com/cdn/9.3.1/data/en_US/champion.json';
        $ddragon_json = file_get_contents($ddragon);
        $this->ddragon_array = json_decode($ddragon_json, true);
    }

    public function results()
    {
        foreach ($this->ddragon_array['data'] as $champ) {
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
        $url = $this->freechampions . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

        if (strpos($url,'EUW') == true) {
            echo 'EUW';
        } else {
            echo 'NA';
        }
    }
}
