<?php

declare(strict_types=1);

class Router
{
    public const ROUTES =
        [
            '/^\/api\/tags\/*$/' => ['controller' => 'TagController', 'action' => 'list'],
            '/^\/api\/tags-top\/*$/' => ['controller' => 'TagController', 'action' => 'topTen'],
            '/^\/api\/tags-new\/*$/' => ['controller' => 'TagController', 'action' => 'newestTen'],
            '/^\/api\/tags\/(?<slug>[\w-]+)\/*$/' => ['controller' => 'TagController', 'action' => 'show'],

            '/^\/api\/videos\/*$/' => ['controller' => 'VideoController', 'action' => 'list'],
            '/^\/api\/videos-tags-top\/*$/' => ['controller' => 'VideoController', 'action' => 'highestNumberOfTags'],
            '/^\/api\/videos-new\/*$/' => ['controller' => 'VideoController', 'action' => 'newestTen'],
            '/^\/api\/videos\/(?<youtubeId>[\w-]{11})\/*$/' => ['controller' => 'VideoController', 'action' => 'show'],
            '/^\/api\/videos\/(?<youtubeId>[\w-]{11})\/tags\/*$/' => ['controller' => 'VideoController', 'action' => 'tags']
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
        foreach (self::ROUTES as $route => $destination) {
            if (preg_match($route, $url, $matches)) {
                $this->controller = $destination['controller'];
                $this->action = $destination['action'];
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