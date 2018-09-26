<?php

//ini_set('display_startup_errors',1);
//ini_set('display_errors',1);
//error_reporting(-1);

use Controller\TagController;
use Controller\VideoController;

require __DIR__ . '/../vendor/autoload.php';
session_start();

$uri = $_SERVER['REQUEST_URI'];

$parts = parse_url($uri);

$path =  $parts['path'];


parse_str($parts['query'], $query);
$youtubeId = $query['youtubeid'];

$paths = explode('/', $uri);

if (count($paths) === 4) {

    //api/tags/slug
    if($paths[2] === 'tags') {

        $slug = end($paths);
        $controller = new TagController();
        $controller->showAction($slug);
    }

    //api/videos/youtubeId
    if($paths[2] === 'videos') {

        $slug = end($paths);
        $controller = new VideoController();
        $controller->showAction($slug);
    }
}

if ($path === '/api/tags') {

    if($youtubeId){
        $controller = new TagController();
        $controller->listAction($youtubeId);
    }else{
        $controller = new TagController();
        $controller->listAction();
    }
}

if ($uri == '/api/tags-top') {

    $controller = new TagController();
    $controller->topTenAction();
}

if ($uri == '/api/tags-new') {

    $controller = new TagController();
    $controller->lastTenAction();
}


if ($uri == '/api/videos') {

    $controller = new VideoController();
    $controller->listAction();
}

if ($uri == '/api/videos-top-tags') {

    $controller = new VideoController();
    $controller->listHighestNumberOfTags();
}

if ($uri == '/api/videos-last-added') {

    $controller = new VideoController();
    $controller->lastTenAction();
}


//if(isset($_SESSION['msg'])) {
//    $msg = $_SESSION['msg'];
//    unset($_SESSION['msg']);
//}
//
