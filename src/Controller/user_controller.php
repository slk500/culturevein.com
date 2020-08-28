<?php

declare(strict_types=1);

use ApiProblem\ApiProblem;
use DTO\RequestUserCreate;
use Model\User;
use Repository\UserRepository;
use Service\TokenService;

/**
 * @throws ApiProblem
 */
function user_create(UserRepository $user_repository, RequestUserCreate $user_create)
{
    if (!filter_var($user_create->email, FILTER_VALIDATE_EMAIL)) {
        throw new ApiProblem(ApiProblem::EMAIL_NOT_VALID);
    }

    if ($user_repository->find($user_create->email)) {
        throw new ApiProblem(ApiProblem::USER_ALREADY_EXIST);
    }

    $user = new User($user_create);

    $user_id = $user_repository->add($user);
    $token = (new TokenService())->create_token($user_id);

    return ['token' => $token];
}

/**
 * @throws ApiProblem
 */
function user_login(UserRepository $user_repository, string $email, string $password): array
{
    if (!$user = $user_repository->find($email)) {
        throw new ApiProblem(ApiProblem::WRONG_CREDENTIALS);
    }

    if (!password_verify($password, $user->password)) {
        throw new ApiProblem(ApiProblem::PASSWORD_MISMATCH);
    }

    $token = (new TokenService())->create_token($user->user_id);

    return ['token' => $token];
}
