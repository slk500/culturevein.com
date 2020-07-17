<?php

declare(strict_types=1);

namespace Controller\Base;


use Service\TokenService;

//todo remove
abstract class BaseController
{
    public ?int $user_id = null;

    public function authentication(string $token): void
    {
        $this->user_id = (new TokenService())->decode_user_id($token);
    }

    public function create_token(int $user_id)
    {
        return (new TokenService())->create_token($user_id);
    }
}