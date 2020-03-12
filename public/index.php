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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Free Champion Rotations</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <meta name="description" 
    content="A simple website displaying the current free weekly champion rotation for League of Legends">
    <meta name="keywords" content="LOL, league of legends, free champions, rotations, current week">
    <style>
        .dark {
            background-color: #fff;
        }
    </style>
</head>

<body>
    <button class="bgButton" onclick="toggle()">Toggle light/dark mode</button>

    <?php
    $verify = new Guzzleclass();
    $verify->verifyNA();
    $verify->verifyEUW();
    if (isset($_POST['EUW'])) {
        $value = 'NA';
        setcookie('NA', $value, strtotime('-30 days'));
        $value = 'EUW';
        setcookie('EUW', $value, strtotime('+30 days'));
        header("refresh:0");
    } elseif (isset($_POST['NA'])) {
        $value = 'EUW';
        setcookie('EUW', $value, strtotime('-30 days'));
        $value = 'NA';
        setcookie('NA', $value, strtotime('+30 days'));
        header("refresh:0");
    } elseif (empty($_COOKIE)) {
        ?>
        <br>
        <h1><span class="error">Please pick a server to reveal the weekly rotation</span></h1>
        <br>
        <?php
    }

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
        ?>
        <h2>Free champions available on <span class="servername"><?php $guzzle->serverCheck();
        ?>
            </span> server in week <?php echo date('W');
    }
    ?>
        </h2>
        <div class="freechampions">
            <?php
            if (isset($_COOKIE["EUW"]) || isset($_COOKIE["NA"])) {
                $guzzle->guzzleResults();
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
        ?>
</body>
<script>
    const body = document.querySelector("body");
    const darkCookie = document.cookie.includes("theme=dark");

    if (darkCookie) {
        body.classList.add("dark");
    }

    function toggle() {
        document.cookie = darkCookie ? "theme=" : "theme=dark";
        body.classList.toggle("dark");
    }
</script>
</html>