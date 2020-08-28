<?php

declare(strict_types=1);

namespace DTO;

class RequestUserCreate implements RequestData
{
    public string $username;

    public string $email;

    public string $password;
}