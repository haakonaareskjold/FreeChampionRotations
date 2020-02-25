<?php

/**
 * the main file to display the json from the REST API
 *
 * @author Haakon Aareskjold
 *
 * @link https://github.com/haakonaareskjold/FreeChampionRotations
 */

declare(strict_types=1);

require_once __DIR__ . "/../vendor/autoload.php";

if (!empty($_GET['key'])) {
    $freechampions = 'https://euw1.api.riotgames.com/lol/platform/v3/champion-rotations?api_key='
    . $_GET['key'];
            
    $champions_json = file_get_contents($freechampions);
    $champions_array = json_decode($champions_json, true);
    $championsID = $champions_array['freeChampionIds'];
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
        <label for="key">Submit the API Key here: </label><input type="text" name="key" autofocus>
        <button type="submit">submit</button>
    </form>
    
    <div class="freechampions">
        <h1>Champions available this week:</h1>
    <?php
    foreach ($championsID as $value) {
        echo $value . "<br>";
    }
    ?>
    </div>
</body>
</html>