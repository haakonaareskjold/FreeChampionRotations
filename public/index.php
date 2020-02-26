<?php

/**
 *
 * @author Haakon Aareskjold
 *
 * @link https://github.com/haakonaareskjold/FreeChampionRotations
 */

declare(strict_types=1);

require_once __DIR__ . "/../src/bootstrap.php";

use App\classes\Api;

if (!empty($_GET['key'])) {
    $fetchID = new api();
    $fetchID->fetchID();
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
    ?>
    </div>
</body>
</html>