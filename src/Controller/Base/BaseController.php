<?php

declare(strict_types=1);

namespace Controller\Base;

abstract class BaseController
{
    protected function response($data): void
    {
        http_response_code(200);
        echo json_encode($data);
    }

    protected function response_created($data): void
    {
        http_response_code(201);
        echo json_encode($data);
    }
}