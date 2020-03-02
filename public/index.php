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
    <!-- For development -->
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
    "<br>";
    ?>
    <h2>Until next rotation:</h2>
    </div>
    <!-- 
        weekly countdown timer from vincoding
        https://vincoding.com/weekly-repeating-countdown-timer-javascript/
     -->
    <script>
        var curday;
        var secTime;
        var ticker;
        
        function getSeconds() {
        var nowDate = new Date();
        var dy = 1 ; //Sunday through Saturday, 0 to 6
        var countertime = new Date(nowDate.getFullYear(),nowDate.getMonth(),nowDate.getDate(),24,0,0); //20 out of 24 hours = 8pm
        
        var curtime = nowDate.getTime(); //current time
        var atime = countertime.getTime(); //countdown time
        var diff = parseInt((atime - curtime)/1000);
        if (diff > 0) { curday = dy - nowDate.getDay() }
        else { curday = dy - nowDate.getDay() -1 } //after countdown time
        if (curday < 0) { curday += 7; } //already after countdown time, switch to next week
        if (diff <= 0) { diff += (86400 * 7) }
        startTimer (diff);
        }
        
        function startTimer(secs) {
        secTime = parseInt(secs);
        ticker = setInterval("tick()",1000);
        tick(); //initial count display
        }
        
        function tick() {
        var secs = secTime;
        if (secs>0) {
        secTime--;
        }
        else {
        clearInterval(ticker);
        getSeconds(); //start over
        }
        
        var days = Math.floor(secs/86400);
        secs %= 86400;
        var hours= Math.floor(secs/3600);
        secs %= 3600;
        var mins = Math.floor(secs/60);
        secs %= 60;
        
        //update the time display
        document.getElementById("days").innerHTML = curday;
        document.getElementById("hours").innerHTML = ((hours < 10 ) ? "0" : "" ) + hours;
        document.getElementById("minutes").innerHTML = ( (mins < 10) ? "0" : "" ) + mins;
        document.getElementById("seconds").innerHTML = ( (secs < 10) ? "0" : "" ) + secs;
        }

        document.addEventListener('DOMContentLoaded', function() {
        getSeconds();
}, false);
</script>
        
    <div id="countholder">
 <div><span class="days" id="days"></span><div class="smalltext">Day(s)</div></div>
 <div><span class="hours" id="hours"></span><div class="smalltext">Hour(s)</div></div>
 <div><span class="minutes" id="minutes"></span><div class="smalltext">Minute(s)</div></div>
 <div><span class="seconds" id="seconds"></span><div class="smalltext">Second(s)</div></div>
</div>
</body>
</html>