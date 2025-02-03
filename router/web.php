<?php

use App\Controllers\HomeController;
use Basri\Router\Router;

$router->group('users', function (Router $router) {
    $router->post('login', [HomeController::class, 'authUser']);
    $router->post('register', [HomeController::class, 'registerStore']);
    $router->get('dashboard', [HomeController::class, 'dashboardPage']);
    $router->get('password/change', [HomeController::class, 'passwordChange']);
    $router->post('password/change', [HomeController::class, 'storePasswordChange']);
});

$router->get('login', [HomeController::class, 'loginPage']);
$router->get('logout', [HomeController::class, 'logout']);
$router->get('register', [HomeController::class, 'registerPage']);