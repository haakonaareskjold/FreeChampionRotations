<?php

namespace API;

/**
 * Class for fetching API
 * Class for converting ID to name
 */

/**
 * API for fetching free champion rotation
 * @api https://developer.riotgames.com/apis#champion-v3/GET_getChampionInfo
 * JSON for all champions
 * @api http://ddragon.leagueoflegends.com/cdn/10.4.1/data/en_US/champion.json
 */

class API
{
    /**
     * method to display champion ID
     *
     * @return void
     */
    public function freeChampions()
    {
        if (isset($_GET['apikey'])) {
            $freechampions = 'https://euw1.api.riotgames.com/lol/platform/v3/champion-rotations?api_key='
            . $_GET['apikey'];
        
            $champions_json = file_get_contents($freechampions);
            $champions_array = json_decode($champions_json, true);
            $championsID = $champions_array['freeChampionIds'];
            # TODO
            # check in second API json for matching IDs and replace with names
            foreach ($championsID as $value) {
                echo $value . "<br>";
            }
        }
    }
}
