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
    <?php
    if (!empty($_POST)) {
        $guzzle = new Guzzleclass();
        $guzzle->fetchID();
    }
    ?>
    <h1>Free Champion Rotations</h1><h1 class="game">League of Legends</h1>
     <form method="POST">
        <input class="submit" type="submit" name="EUW" value="EUW">
        <input class="submit" type="submit" name="NA" value="NA">
    </form>
    <br>
    <hr>
    <?php
    if (empty($_POST)) {
        ?><br><h1><span class="error">Please pick a server to reveal the weekly rotation</span></h1><br><?php
    } else {
        ?><h2>Free champions available on <span class="servername"><?php $guzzle->serverCheck(); ?>
        </span> server in week <?php echo date('W');
    }?></h2>
    <div class="freechampions">
    <?php
    if (!empty($_POST)) {
        $guzzle->guzzleResults();
    }
    "<br>";
    ?>
    </div>
    <?php
    if (isset($_POST['EUW'])) {
        ?>
        <h2>Until next rotation on <span class="servername"><?php $guzzle->serverCheck(); ?>:</h2>
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
        var dy = 2 ; //Sunday through Saturday, 0 to 6
        var countertime = new Date(
            nowDate.getFullYear(),nowDate.getMonth(),nowDate.getDate(),2,0,0); //20 out of 24 hours = 8pm
        
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
        <?php
    }
    ?>
<?php
if (isset($_POST['NA'])) {
    ?>
        <h2>Until next rotation on <span class="servername"><?php $guzzle->serverCheck(); ?>:</h2>
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
        var dy = 2 ; //Sunday through Saturday, 0 to 6
        var countertime = new Date(
            nowDate.getFullYear(),nowDate.getMonth(),nowDate.getDate(),13,0,0); //20 out of 24 hours = 8pm
        
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
    <?php
}
?>
<?php
if (isset($_POST['EUW']) || isset($_POST['NA'])) {
    ?>
    <div id="countholder">
 <div><span class="days" id="days"></span><div class="smalltext">Day(s)</div></div>
 <div><span class="hours" id="hours"></span><div class="smalltext">Hour(s)</div></div>
 <div><span class="minutes" id="minutes"></span><div class="smalltext">Minute(s)</div></div>
 <div><span class="seconds" id="seconds"></span><div class="smalltext">Second(s)</div></div>
</div>
    <?php
}
?>
</body>
</html>