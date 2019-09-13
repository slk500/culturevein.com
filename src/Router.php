<?php

declare(strict_types=1);

final class Router
{
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

    /**
     * @var array
     */
    private $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function match(string $url): bool
    {
        foreach ($this->routes as $route) {
            if (preg_match($route[0], $url, $matches) &&
                ($route[3] === $_SERVER['REQUEST_METHOD'] || $_SERVER['REQUEST_METHOD'] == 'OPTIONS')) {

                $this->controller = $route[1];
                $this->action = $route[2];
                $this->param = $matches;

                return true;
            }
        }
        return false;
    }

    public function dispatch(string $url)
    {
        if ($this->match($url)) {
            $controller = new $this->controller();
            $actionName = $this->action;

            //todo shitfix
            $param1 = $this->param[1] ?? null;
            $param2 = $this->param[2] ?? null;
            $param3 = $this->param[3] ?? null;

           echo $controller->$actionName($param1, $param2, (int) $param3);
        }
    }
}

