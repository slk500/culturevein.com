<?php

declare(strict_types=1);

use ApiProblem\ApiProblem;
use DTO\RequestData;
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
        if ($result) echo json_encode(['data' => $result]);

    } catch (ApiProblem $apiProblem) {
        http_response_code($apiProblem->getCode());
        echo json_encode($apiProblem->getMessage());
    } catch (\Throwable $throwable) {
        http_response_code(500);
        echo json_encode($throwable->getMessage());
    }
}

function read_parameters_from_function(string $function_name): array
{
    return array_map(function (ReflectionParameter $reflection_parameter) {
        return [
            'name' => $reflection_parameter->getName(),
            'type' => ($reflection_parameter->getType())->getName(),
        ];
    }, (new ReflectionFunction($function_name))->getParameters());
}

//it's done in one go -> should be split into 3 functions to increase readability
function autowire_arguments(array $parameters, array $match, Container $container): array
{
    return array_map(function ($parameter) use ($match, $container) {

        //scalar types
        if (array_key_exists($parameter['name'], $match['path_arguments'])) {
            if ($parameter['type'] == 'int') return intval($match['path_arguments'][$parameter['name']]);
            return $match['path_arguments'][$parameter['name']];
        }

        if ($match['body_arguments']) {
            if (array_key_exists($parameter['name'], $match['body_arguments'])) {
                return $match['body_arguments'][$parameter['name']];
            }
        }

        if ($parameter['name'] === 'user_id') {
            return find_logged_user_id();
        }

        //requestData
        if (is_a($parameter['type'], RequestData::class, true)) {
            return autowire_request_data($match['body_arguments'], $match['path_arguments'], $parameter['type']);
        }

        if ($parameter['type'] === 'string' || $parameter['type'] === 'int') {
            throw new Exception(
                "Could not autowire argument: {$parameter['type']} \${$parameter['name']}");
        }

        //service from container
        return $container->get($parameter['type']);
    }, $parameters);
}

//some arguments comes form body others from query_string
function autowire_request_data(array $body_arguments, array $path_arguments, string $class_name)
{
    $arguments = array_merge($body_arguments, $path_arguments);

    $properties_names = array_map(fn(ReflectionProperty $property) => $property->getName(),
        (new ReflectionClass($class_name))->getProperties());

    foreach ($properties_names as $property) {
        if ($property === 'user_id') continue;
        if (!array_key_exists($property, $arguments)) throw new ApiProblem( //throws invalid argument exception - todo fix
            ["There was a validation error. Missing field: $property", 422]
        );
    }

    $request_data = recast($class_name, $arguments);

    if (in_array('user_id', $properties_names)) {
        $request_data->user_id = find_logged_user_id();
    }
    return $request_data;
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
