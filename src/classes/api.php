<?php

namespace App\Classes;

class Api
{
    private $id;
    private $ddragon_array;
    private const EUW_SERVER = "https://euw1.api.riotgames.com/";
    private const NA_SERVER = "https://na1.api.riotgames.com/";
    

    public function fetchID()
    {

        if (isset($_GET['EUW'])) {
            $freechampions = self::EUW_SERVER . 'lol/platform/v3/champion-rotations?api_key=' . $_GET['key'];
        } else {
            $freechampions = self::NA_SERVER . 'lol/platform/v3/champion-rotations?api_key=' . $_GET['key'];
        }
        $champions_json = file_get_contents($freechampions);
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
                    echo $champ["id"] . "<br>";
                }
            }
        }
    }
}
