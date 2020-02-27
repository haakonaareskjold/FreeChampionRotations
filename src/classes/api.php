<?php

namespace App\Classes;

class Api
{
    private $id;
    public $ddragon_array;

    public function fetchID()
    {

        $freechampions = 'https://euw1.api.riotgames.com/lol/platform/v3/champion-rotations?api_key='
        . $_GET['key'];
                
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
