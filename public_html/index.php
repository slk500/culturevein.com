<?php
declare(strict_types=1);

ini_set('display_startup_errors','1');
ini_set('display_errors','1');
error_reporting(-1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: *");

if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header( "HTTP/1.1 200 OK" );
    exit;
}

require __DIR__ . '/../vendor/autoload.php';

$router = new Router();

$url = $_SERVER['REQUEST_URI'];

if (!$router->match($url)){
    http_response_code(404);
}

$router->dispatch($url);

