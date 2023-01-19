<?php

declare(strict_types=1);

ini_set('display_startup_errors', '1');
ini_set('display_errors', '1');
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, PATCH, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: *");
header('Content-type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit;
}

require __DIR__ . '/../vendor/autoload.php';

$match = find_route(include __DIR__ . '/../config/routes.php',
    $_SERVER['REQUEST_URI'],
    $_SERVER['REQUEST_METHOD']);

$match ? dispatch($match) : http_response_code(404);
