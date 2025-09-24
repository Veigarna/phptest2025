<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require __DIR__ . '/vendor/autoload.php';

define("BASE_URL", "/GuestSimple/");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
