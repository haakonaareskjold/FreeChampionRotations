<?php

namespace App\classes;

class Api
{
    private $id;

    public function fetchID()
    {
        $freechampions = 'https://euw1.api.riotgames.com/lol/platform/v3/champion-rotations?api_key='
        . $_GET['key'];
                
        $champions_json = file_get_contents($freechampions);
        $champions_array = json_decode($champions_json, true);
        $this->id = $champions_array['freeChampionIds'];
    }

    public function results()
    {
        foreach ($this->id as $value) {
            echo $value . "<br>";
        }
    }

    public function convert()
    {
        $ddragon = 'http://ddragon.leagueoflegends.com/cdn/9.3.1/data/en_US/champion.json';
        $ddragon_json = file_get_contents($ddragon);
        $ddragon_array = json_decode($ddragon_json, true);
        $ddragon_id = $ddragon_array['data'][0]['key'];
        if ($ddragon_id == $this->id) {
            foreach ($ddragon_id['data'][0]['key'] as $row) {
                echo $row;
            }
        }
    }
}
