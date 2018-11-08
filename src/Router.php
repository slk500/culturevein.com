<?php

declare(strict_types=1);

final class Router
{
    public const ROUTES =
        [
            ['route' => '/^\/api\/artists\/*$/', 'controller' => 'ArtistController', 'action' => 'list', 'method' => 'GET'],

            ['route' => '/^\/api\/tags\/*$/', 'controller' => 'TagController', 'action' => 'create', 'method' => 'POST'],
            ['route' => '/^\/api\/tags\/*$/', 'controller' => 'TagController', 'action' => 'list', 'method' => 'GET'],

            ['route' => '/^\/api\/tags-top\/*$/', 'controller' => 'TagController', 'action' => 'top_ten', 'method' => 'GET'],
            ['route' => '/^\/api\/tags-new\/*$/', 'controller' => 'TagController', 'action' => 'newest_ten', 'method' => 'GET'],
            ['route' => '/^\/api\/tags\/(?<slug>[\w-]+)\/*$/', 'controller' => 'TagController', 'action' => 'show', 'method' => 'GET'],

            ['route' => '/^\/api\/videos\/*$/', 'controller'=> 'VideoController', 'action' => 'create', 'method' => 'POST'],
            ['route' => '/^\/api\/videos\/*$/', 'controller'=> 'VideoController', 'action' => 'list', 'method' => 'GET'],
            ['route' => '/^\/api\/videos-tags-top\/*$/', 'controller' => 'VideoController', 'action' => 'highest_number_of_tags', 'method' => 'GET'],
            ['route' => '/^\/api\/videos-new\/*$/', 'controller' => 'VideoController', 'action' => 'newest_ten', 'method' => 'GET'],
            ['route' => '/^\/api\/videos\/(?<youtubeId>[\w-]{11})\/*$/', 'controller' => 'VideoController', 'action' => 'show', 'method' => 'GET'],
            ['route' => '/^\/api\/videos\/(?<youtubeId>[\w-]{11})\/tags\/*$/', 'controller' => 'VideoController', 'action' => 'tags', 'method' => 'GET'],

            ['route' => '/^\/api\/videos\/(?<youtubeId>[\w-]{11})\/tags\/(?<videoTagId>[\d-]+)*$/', 'controller' => 'VideoTagController', 'action' => 'delete', 'method' => 'GET'],

            ['route' => '/^\/api\/youtube\/(?<youtubeId>[\w-]{11})\/*$/', 'controller' => 'YouTubeController', 'action' => 'get_artist_and_title', 'method' => 'GET']
        ];

    public const METHODS_WITH_INPUT = [
      'POST', 'PATCH'
    ];

    /**
     * @var string
     */
    private $param;

    /**
     * @var string
     */
    private $controller;

    /**
     * @var string
     */
    private $action;

    public function match(string $url): bool
    {
        foreach (self::ROUTES as $route) {
            if (preg_match($route['route'], $url, $matches) &&
                ($route['method'] === $_SERVER['REQUEST_METHOD'] || $_SERVER['REQUEST_METHOD'] == 'OPTIONS')) {

                $this->controller = $route['controller'];
                $this->action = $route['action'];
                $this->param = $this->get_params($route, $matches);
                return true;
            }
        }
        return false;
    }

    public function dispatch(string $url)
    {
        if ($this->match($url)) {
            $controllerName = 'Controller\\' . $this->controller;
            $controller = new $controllerName();

            $actionName = $this->action;
            $controller->$actionName($this->param);
        }
    }

    private function get_params(array $route, array $matches)
    {
        if (in_array($route['method'], self::METHODS_WITH_INPUT) && in_array($_SERVER['REQUEST_METHOD'], self::METHODS_WITH_INPUT)) {
            $body = file_get_contents('php://input');
            return json_decode($body);
        }

        return end($matches);
    }
}