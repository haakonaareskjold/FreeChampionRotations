<?php

require_once __DIR__ . "/../vendor/autoload.php";

//env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

//misc
date_default_timezone_set('Europe/Berlin'); //sets timezone to UTC+1
