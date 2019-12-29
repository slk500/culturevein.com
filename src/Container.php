<?php

declare(strict_types=1);

final class Container
{
    private $service_store = [];

    private $config = [];

    public function __construct()
    {
        $this->config = include __DIR__ . '/../config/services.php';
    }

    public function get(string $name): object
    {
       return $this->service_store[$name] = $this->service_store[$name] ?? $this->create_service($name);
    }

    private function create_service(string $name): object
    {
        return new $name(...array_map(function (string $dependency){
            return $this->get($dependency);
        }, $this->config[$name]));
    }
}

