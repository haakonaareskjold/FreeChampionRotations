<?php

/**
 * the main file to display the json from the REST API
 *
 * @author Haakon Aareskjold <aareskjold.haakon@gmail.com>
 *
 * @link https://github.com/haakonaareskjold/FreeChampionRotations
 */

declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";

/**
 * API for fetching free champion rotation
 * @api https://developer.riotgames.com/apis#champion-v3/GET_getChampionInfo
 * JSON for all champions
 * @api http://ddragon.leagueoflegends.com/cdn/10.4.1/data/en_US/champion.json
 */

if (isset($_GET['apikey'])) {
    $freechampions = 'https://euw1.api.riotgames.com/lol/platform/v3/champion-rotations?api_key='
    . $_GET['apikey'];

    $champions_json = file_get_contents($freechampions);
    $champions_array = json_decode($champions_json, true);
    $championsID = $champions_array['freeChampionIds'];
    # TODO
    # check in second API json for matching IDs and replace with names
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Free Champions Rotations</title>
</head>
<body>
    <form action="GET">
        <label for="apikey">Submit the API Key here: </label><input type="text" name="apikey" autofocus>
        <button type="submit">submit</button>
    </form>
    <div class="champions">
    <?php
    foreach ($championsID as $value) {
        echo $value . "<br>";
    }
    ?>
    </div>
</body>
</html>