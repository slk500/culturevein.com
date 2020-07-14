<?php

declare(strict_types=1);


namespace Model;


class User
{
    public string $email;

    public string $password;

    public string $username;
    /**
     * @var int
     */
    public $user_id;

    public function __construct(string $email, string $password, string $username)
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new \Exception('Not valid email');
        };

        $this->email = $email;
        $this->password = $password;
        $this->username = $username;
    }
}