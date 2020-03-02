<?php

/**
 *
 * @author Haakon Aareskjold
 *
 * @link https://github.com/haakonaareskjold/FreeChampionRotations
 */

declare(strict_types=1);

require_once __DIR__ . "/../src/bootstrap.php";

use App\Classes\Guzzleclass;


if (!empty($_GET['key'])) {
    $guzzle = new Guzzleclass();
    $guzzle->fetchID();
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
    <h1>Free Champions Rotations League of Legends</h1>
    <form action="GET">
        <label for="key">Submit the API Key here: </label><input type="text" name="key" autofocus 
        placeholder="RGAPI-68437c4c-a743-424a-b548-a16f5a074d5e">
        <br>
        <br>
        <label for="EUW">EUW</label><input type="radio" name="location" value="EUW" checked>
        <label for="NA">NA</label><input type="radio" name="location" value="NA">
        <br>
        <button class="submit" type="submit">submit</button>
    </form>
    <br>
    <hr>
    <?php
    if (!empty($_GET['key'])) {
        ?>
    <h2>Free champions available on <span class="servername"><?php $guzzle->serverCheck(); ?></span> server in week <?php echo date('W'); ?></h2>
        <?php
    } else {
        echo "<h2><span class='error'>Please submit a valid API key to be able to see the content</span></h2>";
    }
    ?>
    <div class="freechampions">
    <?php
    if (!empty($_GET['key'])) {
        $guzzle->guzzleResults();
    }
    ?>
    <br>
    </div>
</body>
</html>