<?php

namespace App\classes;

class Api
{

    public function fetchID()
    {
        $freechampions = 'https://euw1.api.riotgames.com/lol/platform/v3/champion-rotations?api_key='
        . $_GET['key'];
                
        $champions_json = file_get_contents($freechampions);
        $champions_array = json_decode($champions_json, true);
        $id = $champions_array['freeChampionIds'];

        foreach ($id as $value) {
            echo $value . "<br>";
        }
    }
}
