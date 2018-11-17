<?php

declare(strict_types=1);


namespace Tests\Builder;


use Model\User;

class UserBuilder
{
    private $email = 'slawomir.grochowski@gmail.com';

    private $username = 'slk500';

    private $password = 'password';


    public function build(): User
    {
        $password_encrypted = password_hash($this->password, PASSWORD_BCRYPT);

        $user = new User(
            $this->email,
            $password_encrypted,
            $this->username
        );

        return $user;
    }
}