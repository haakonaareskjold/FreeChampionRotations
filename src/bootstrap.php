<?php

require_once __DIR__ . "/../vendor/autoload.php";

//env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();
