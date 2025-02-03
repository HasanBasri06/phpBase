<?php

use Basri\Router\Router;

session_start();
define('START_TIME', microtime(true));

if (!isset($_SESSION['CSRF_TOKEN'])) {
    $_SESSION['CSRF_TOKEN'] = random_int(00000000000000000, 999999999999999999);
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);


require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/config.php';

$router = new Router;

include_once __DIR__ . '/router/web.php';

$router->dispatch();