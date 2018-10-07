<?php

namespace Controller;

abstract class BaseController
{
    protected function response($data): void
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}