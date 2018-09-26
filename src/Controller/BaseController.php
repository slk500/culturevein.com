<?php

namespace Controller;

use Repository\TagRepository;

abstract class BaseController
{
    protected $tagRepository;

    public function __construct()
    {
        $this->tagRepository = new TagRepository();
    }

    protected function response($data): void
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}