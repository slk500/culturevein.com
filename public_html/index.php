<?php

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

require __DIR__ . '/../vendor/autoload.php';

$router = new Router();

$url = $_SERVER['REQUEST_URI'];

if (!$router->match($url)){
    http_response_code(404);
}

$router->dispatch($url);

