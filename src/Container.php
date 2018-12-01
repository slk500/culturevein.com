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
        $this->service_store[$name] = $this->service_store[$name] ??  $this->create_service($name);
        return $this->service_store[$name];
    }

    private function create_service(string $name): object
    {
        $dependencies = [];
        foreach ($this->config[$name] as $dependencie){
            $dependencies []= $this->get($dependencie);
        }

        return new $name(...$dependencies);
    }
}
