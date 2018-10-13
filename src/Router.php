<?php

class Router
{
    private $routes = [];

    private $param;

    private $controller = '';

    private $action = '';

    public function add($route, $destination)
    {
        $this->routes[$route] = $destination;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function match(string $url): bool
    {
        foreach ($this->routes as $route => $destination){
            if (preg_match($route, $url, $matches)){
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
         if($this->match($url)){
             $controllerName = 'Controller\\' . $this->controller;
             $controller = new $controllerName();

             $actionName = $this->action;
             $controller->$actionName($this->param);
         }
    }
}