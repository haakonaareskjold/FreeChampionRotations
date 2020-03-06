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
</head>

<body>
    <script>
        function whiteMode() {
            var element = document.body;
            element.classList.toggle("white-mode");
        }
    </script>
    <button class="bgButton" onclick="whiteMode()">Toggle White/Dark mode</button>
    <?php
    if (!empty($_POST)) {
        $guzzle = new Guzzleclass();
        $guzzle->fetchID();
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
    if (empty($_POST)) {
        ?>
        <br>
        <h1><span class="error">Please pick a server to reveal the weekly rotation</span></h1>
        <br>
        <?php
    } else {
        ?>
        <h2>Free champions available on <span class="servername"><?php $guzzle->serverCheck();
        ?>
        </span> server in week <?php echo date('W');
    }
    ?>
    </h2>
        <div class="freechampions">
            <?php
            if (!empty($_POST)) {
                $guzzle->guzzleResults();
            }
            "<br>";
            ?>
        </div>
        <?php
         $cd = new CountholderClass();
        if (isset($_POST['EUW'])) {
            ?>
            <h2>Until next rotation on <span class="servername"><?php $guzzle->serverCheck(); ?>:</h2>
            <?php
            $cd->euwTimer();
        }?>
        <?php
        if (isset($_POST['NA'])) {
            ?>
            <h2>Until next rotation on <span class="servername"><?php $guzzle->serverCheck(); ?>:</h2>
            <?php
            $cd->naTimer();
        }?>
        <?php
        if (isset($_POST['EUW']) || isset($_POST['NA'])) {
            $cd->countholder();
        }
        ?>
</body>
</html>