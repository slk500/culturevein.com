<?php

declare(strict_types=1);

use Repository\UserRepository;

function user(UserRepository $user_repository)
{
    return $user_repository->find_statistics();
}