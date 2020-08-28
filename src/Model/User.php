<?php

declare(strict_types=1);


namespace Model;


use DTO\RequestUserCreate;

class User
{
    public string $email;

    public string $password;

    public string $username;

    public ?int $user_id = null;

    public function __construct(RequestUserCreate $user_create)
    {
        $email = filter_var($user_create->email, FILTER_SANITIZE_EMAIL);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new \Exception('Not valid email');
        };

        $password_encrypted = password_hash($user_create->password, PASSWORD_BCRYPT);

        $this->email = $user_create->email;
        $this->password = $password_encrypted;
        $this->username = $user_create->username;
    }
}