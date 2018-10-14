<?php

declare(strict_types=1);

final class Router
{
    public const ROUTES =
        [
            ['route' => '/^\/api\/tags\/*$/', 'controller' => 'TagController', 'action' => 'create', 'method' => 'POST'],
            ['route' => '/^\/api\/tags\/*$/', 'controller' => 'TagController', 'action' => 'list', 'method' => 'GET'],
            ['route' => '/^\/api\/tags-top\/*$/', 'controller' => 'TagController', 'action' => 'topTen', 'method' => 'GET'],
            ['route' => '/^\/api\/tags-new\/*$/', 'controller' => 'TagController', 'action' => 'newestTen', 'method' => 'GET'],
            ['route' => '/^\/api\/tags\/(?<slug>[\w-]+)\/*$/', 'controller' => 'TagController', 'action' => 'show', 'method' => 'GET'],
            ['route' => '/^\/api\/videos\/*$/', 'controller'=> 'VideoController', 'action' => 'list', 'method' => 'GET'],
            ['route' => '/^\/api\/videos-tags-top\/*$/', 'controller' => 'VideoController', 'action' => 'highestNumberOfTags', 'method' => 'GET'],
            ['route' => '/^\/api\/videos-new\/*$/', 'controller' => 'VideoController', 'action' => 'newestTen', 'method' => 'GET'],
            ['route' => '/^\/api\/videos\/(?<youtubeId>[\w-]{11})\/*$/', 'controller' => 'VideoController', 'action' => 'show', 'method' => 'GET'],
            ['route' => '/^\/api\/videos\/(?<youtubeId>[\w-]{11})\/tags\/*$/', 'controller' => 'VideoController', 'action' => 'tags', 'method' => 'GET']
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
                $this->param = end($matches);
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
}