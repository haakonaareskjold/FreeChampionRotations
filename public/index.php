<?php

/**
 *
 * @author Haakon Aareskjold
 *
 * @link https://github.com/haakonaareskjold/FreeChampionRotations
 */

declare(strict_types=1);

require_once __DIR__ . "/../src/bootstrap.php";

use App\Classes\CountholderClass;
use App\Classes\Guzzleclass;
use App\Classes\LocationClass;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <title>Free Champion Rotations</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <meta name="description" 
    content="A simple website displaying the current free weekly champion rotation for League of Legends">
    <meta name="keywords" content="LOL, league of legends, free champions, rotations, current week">
</head>

<body>
    <button class="bgButton" onclick="toggle()">Toggle light/dark mode</button>
    <a href="https://github.com/haakonaareskjold/FreeChampionRotations" target="_blank">
    <img src="GitHub-Mark-32px.png" alt="Github logo" class="github"></a>

    <?php
    /**
     * check if guzzle can fetch riot API with ENV key
     * then if both NA and EUW has connection without errors
     */
    $verify = new Guzzleclass();
    $verify->verifyNA();
    $verify->verifyEUW();
    
    //geolocation
    $location = new LocationClass();
    $location->getIP();
    $location->fetch();
    $location->pickServer();
    $location->geoLocation();
    ?>

    <h1>Free Champion Rotations</h1>
    <h1 class="game">League of Legends</h1>
    <form method="POST">
        <input class="submit" type="submit" name="EUW" value="EUW">
        <input class="submit" type="submit" name="NA" value="NA">
    </form>
    <br>
    <hr>
    <?php
    $guzzle = new Guzzleclass();
    if (isset($_COOKIE['EUW']) || isset($_COOKIE["NA"])) {
        $guzzle->fetchID();
        $guzzle->cacheChampions();
        ?>
        <h2>Free champions available on <span class="servername"><?php $guzzle->serverCheck();
        ?>
            </span> server in week 
            <?php
            if (isset($_COOKIE['EUW'])) {
             echo date('W', strtotime("- 1 day - 2 hour"));
            } elseif (isset($_COOKIE['NA'])) {
                echo date('W', strtotime("- 1 day - 9 hour"));
                // echo date('W', strtotime("- 1 day - 8 hour"));
                //replace with this if no DST
             }
    }
    ?>
        </h2>
        <div class="freechampions">
            <?php
            if (isset($_COOKIE["EUW"]) || isset($_COOKIE["NA"])) {
                $guzzle->currentWeek();
                ?> <h2> Additional champions available in <span class="servername"> ARAM</span> only: </h2>
                <?php
                $guzzle->aramChampions();
            }
            "<br>";
            ?>
        </div>
        <?php
        $cd = new CountholderClass();
        if (isset($_COOKIE["EUW"])) {
            ?>
            <h2>Until next rotation on <span class="servername"><?php $guzzle->serverCheck(); ?>:</h2>
            <?php
            $cd->euwTimer();
        } ?>
        <?php
        if (isset($_COOKIE["NA"])) {
            ?>
            <h2>Until next rotation on <span class="servername"><?php $guzzle->serverCheck(); ?>:</h2>
            <?php
            $cd->naTimer();
        } ?>
        <?php
        if (isset($_COOKIE["EUW"]) || isset($_COOKIE["NA"])) {
            $cd->countholder();
        }
        $guzzle->clearCache();
        ?>
</body>
<script>
    const body = document.querySelector("body");
    const darkCookie = document.cookie.includes("theme=dark");

    if (darkCookie) {
        body.classList.add("dark");
    }

    function toggle() {
        document.cookie = darkCookie ? "theme=" : "theme=dark;max-age=31536000";
        body.classList.toggle("dark");
    }
</script>
</html>