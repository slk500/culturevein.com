<?php

declare(strict_types=1);

namespace Controller\Base;

abstract class BaseController
{
    protected function response($data = null): void
    {
        http_response_code(200);
        echo json_encode($data);
    }

    protected function response_unauthorized($data = null): void
    {
        http_response_code(401);
        echo json_encode($data);
    }

    protected function response_created($data = null): void
    {
        http_response_code(201);
        if($data) {
            echo json_encode($data);
        }
    }
}