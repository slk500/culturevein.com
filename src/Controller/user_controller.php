<?php

declare(strict_types=1);

use ApiProblem\ApiProblem;
use Model\User;
use Repository\UserRepository;

/**
 * @throws ApiProblem
 */
function create(UserRepository $user_repository, \stdClass $data)
{
    foreach (['username', 'email', 'password'] as $field) {
        if (!property_exists($data, $field)) {
            throw new ApiProblem(ApiProblem::ALL_FIELDS_HAVE_TO_BE_FILLED);
        }
    }

    if (!filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
        throw new ApiProblem(ApiProblem::EMAIL_NOT_VALID);
    }

    if ($user_repository->find($data->email)) {
        throw new ApiProblem(ApiProblem::USER_ALREADY_EXIST);
    }

    $password_encrypted = password_hash($data->password, PASSWORD_BCRYPT);

    $user = new User(
        $data->email,
        $password_encrypted,
        $data->username
    );

    $user_id = $user_repository->add($user);
    $token = create_token($user_id);

    return ['token' => $token];
}

/**
 * @throws ApiProblem
 */
function login(UserRepository $user_repository, \stdClass $data): array
{
    if (!property_exists($data, 'email') ||
        !property_exists($data, 'password') ||
        !$user = $user_repository->find($data->email)
    ) {
        throw new ApiProblem(ApiProblem::WRONG_CREDENTIALS);
    }

    if (!password_verify($data->password, $user->password)) {
        throw new ApiProblem(ApiProblem::PASSWORD_MISMATCH);
    }

    $token = create_token($user->user_id);

    return ['token' => $token];
}
