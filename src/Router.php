<?php

declare(strict_types=1);

final class Router
{
    private array $routes;

    private array $param;

    private string $controller;

    private string $action;

    private string $method;

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
                $this->method = $route[3];
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

            $this->set_status_code($this->method);
            echo $controller->$actionName($param1, $param2, (int)$param3);
        }
    }

    public function set_status_code(string $method): void
    {
        switch ($method) {
            case 'GET':
                http_response_code(200);
                break;
            case 'POST':
                http_response_code(201);
                break;
        }
    }
}

