<?php

declare(strict_types=1);

namespace Controller;


use Controller\Base\BaseController;
use Model\User;

class UserController extends BaseController
{
    public function create(object $data)
    {
        new User(
            $data->email,
            $data->password,
            $data->username
        );

        $this->response_created();
    }

    public function log_in(object $data)
    {

    }
}