<?php

declare(strict_types=1);


namespace Model;


class User
{
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $password;
    /**
     * @var string
     */
    public $username;

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