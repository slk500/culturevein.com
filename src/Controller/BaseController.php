<?php

declare(strict_types=1);

namespace Controller;

abstract class BaseController
{
    protected function response($data): void
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

        echo json_encode($data);
    }
}