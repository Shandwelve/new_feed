<?php

declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);


use application\core\Router;

spl_autoload_register(function ($class) {
    $path = str_replace('\\', '/', $class . '.php');
    if (file_exists($path)) {
        require $path;
    }
});

session_start();
$router = new Router();
$router->run();

