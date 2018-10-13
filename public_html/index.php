<?php

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

require __DIR__ . '/../vendor/autoload.php';

$router = new Router();

$router->add('/^\/api\/tags\/*$/',['controller' => 'TagController', 'action' => 'list']);
$router->add('/^\/api\/tags-top\/*$/',['controller' => 'TagController', 'action' => 'topTen']);
$router->add('/^\/api\/tags-new\/*$/',['controller' => 'TagController', 'action' => 'lastTen']);
$router->add('/^\/api\/tags\/(?<slug>\w+)\/*$/',['controller' => 'TagController', 'action' => 'show']);

$router->add('/^\/api\/videos\/*$/',['controller' => 'VideoController', 'action' => 'list']);
$router->add('/^\/api\/videos-tags-top\/*$/',['controller' => 'VideoController', 'action' => 'highestNumberOfTags']);
$router->add('/^\/api\/videos-new\/*$/',['controller' => 'VideoController', 'action' => 'lastTen']);

$router->add('/^\/api\/videos\/(?<youtubeId>\w+)\/*$/',['controller' => 'VideoController', 'action' => 'show']);
$router->add('/^\/api\/videos\/(?<youtubeId>\w+)\/tags\/*$/',['controller' => 'VideoController', 'action' => 'show']);

$url = $_SERVER['REQUEST_URI'];

if (!$router->match($url)){
    http_response_code(404);
}

$router->dispatch($url);

