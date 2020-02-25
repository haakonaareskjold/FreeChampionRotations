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

use API\API;



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
    $championsID = new API();
    $championsID->freeChampions();
    ?>
    </div>
</body>
</html>