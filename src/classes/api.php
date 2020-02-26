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
}
