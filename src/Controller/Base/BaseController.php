<?php

declare(strict_types=1);

namespace Controller\Abstraction;

abstract class BaseController
{
    protected function response($data): void
    {
        http_response_code(200);
        echo json_encode($data);
    }

    protected function responseCreated($data): void
    {
        http_response_code(201);
        echo json_encode($data);
    }
}