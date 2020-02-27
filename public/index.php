<?php

/**
 *
 * @author Haakon Aareskjold
 *
 * @link https://github.com/haakonaareskjold/FreeChampionRotations
 */

declare(strict_types=1);

require_once __DIR__ . "/../src/bootstrap.php";

use App\Classes\Api;

if (!empty($_GET['key'])) {
    $result = new api();
    $result->fetchID();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Free Champions Rotations</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form action="GET">
        <label for="key">Submit the API Key here: </label><input type="text" name="key" autofocus 
        placeholder="RGAPI-68437c4c-a743-424a-b548-a16f5a074d5e">
        <label for="EUW">EUW</label><input type="radio" name="EUW" value="EUW">
        <label for="NA">NA</label><input type="radio" name="NA" value="NA">
        <button type="submit">submit</button>
    </form>
    <br>
    <div class="freechampions">
        <h1>Champions available on EUW in week <?php echo date('W'); ?>:</h1>
    <?php
    $result->results();
    ?>
    <br>
    </div>
</body>
</html>