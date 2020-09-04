<?php

declare(strict_types=1);

use ApiProblem\ApiProblem;
use Service\TokenService;

function match(array $routes, string $url, string $http_method): ?array
{
    foreach ($routes as $route) {
        if (preg_match($route[0], $url, $matches) && ($route[2] === $http_method)) {

            $filtered_path_arguments = array_filter($matches, fn($key) => !is_int($key), ARRAY_FILTER_USE_KEY);

            return [
                'function_name' => $route[1],
                'http_method' => $route[2],
                'path_arguments' => $filtered_path_arguments,
                'body_arguments' => get_body()
            ];
        }
    }
    return null;
}

function dispatch(array $match): void
{
    $parameters = read_parameters_from_function($match['function_name']);

    try {
        $arguments = autowire_arguments($parameters, $match, new Container());

        $result = call_user_func_array($match['function_name'], $arguments);
        set_status_code($match['http_method']);
        if (null !== $result) {
            echo json_encode(['data' => $result]);
        }

    } catch (ApiProblem $apiProblem) {
        http_response_code($apiProblem->getCode());
        echo json_encode($apiProblem->getMessage());
    } catch (\Throwable $throwable) {
        http_response_code(500);
        echo json_encode( $throwable->getMessage());
    }
}

function find_logged_user_id(): ?int
{
    $authorization_header = find_authorization_header();
    $token = $authorization_header ? find_token($authorization_header) : null;

    if (!$token) {
        return null;
    }

    return (new TokenService())->decode_user_id($token);
}

function set_status_code(string $http_method): void
{
    switch ($http_method) {
        case 'GET':
            http_response_code(200);
            break;
        case 'POST':
            http_response_code(201);
            break;
        case 'DELETE':
            http_response_code(204);
            break;
    }
}

//todo replace it with just parameters?
function get_body(): ?array
{
    return json_decode(file_get_contents('php://input'), true);
}
