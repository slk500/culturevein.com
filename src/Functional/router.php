<?php

declare(strict_types=1);

use ApiProblem\ApiProblem;
use DTO\RequestData;
use DTO\VideoCreate;
use Service\TokenService;

function match(array $routes, string $url, string $method): ?array
{
    foreach ($routes as $route) {
        if (preg_match($route[0], $url, $matches) &&
            ($route[2] === $method || $method == 'OPTIONS')) {

            return [
                'function' => $route[1],
                'method' => $route[2],
                'param' => $matches,
                'body' => get_body()
            ];
        }
    }
    return null;
}

function recast($className, stdClass $object)
{
    if (!class_exists($className))
        throw new InvalidArgumentException(sprintf('Inexistant class %s.', $className));

    $new = new $className();
    foreach ($object as $property => $value) {
        $new->$property = $value;
    }

    return $new;
}

//todo refactor!
function dispatch(array $match): void
{
    $reflection_function = new ReflectionFunction($match['function']);

    $parameters = array_map(function (ReflectionParameter $reflection_parameter) {
        return [
            'name' => $reflection_parameter->getName(),
            'type' => ($reflection_parameter->getType())->getName(),
        ];
    }, $reflection_function->getParameters());

    try {
    $arguments = autowire_arguments($parameters, $match, new Container());

        $result = call_user_func_array($match['function'], $arguments);
        set_status_code($match['method']);
        echo json_encode(['data' => $result]);

    } catch (ApiProblem $apiProblem) {
        http_response_code($apiProblem->getCode());
        echo json_encode($apiProblem->getMessage());
    } catch (\Throwable $throwable) {
        http_response_code(500);
        echo json_encode($throwable->getMessage());
    }
}

function autowire_arguments(array $parameters, array $match, Container $container)
{
   return array_map(function ($parameter) use ($match, $container) {

       //scalar types
        if (array_key_exists($parameter['name'], $match['param'])) {
            return $match['param'][$parameter['name']];
        }

        //requestData
        if ($parameter['type'] === RequestData::class) {
            return autowire_request_data($match);
        }

        //service from container
        return $container->get($parameter['type']);
    }, $parameters);
}

function autowire_request_data(array $match)
{
    $reflect = new ReflectionClass(VideoCreate::class);
    $props = $reflect->getProperties();

    $properties = array_map(fn(ReflectionProperty $property) => $property->getName(), $props);

    foreach ($properties as $property) {
        if ($property === 'user_id') continue;
        if (!property_exists($match['body'], $property)) throw new ApiProblem( //throws invalid argument exception - todo fix
            ["There was a validation error. Missing field: $property", 422]
        );
    }

    $request_data = recast(VideoCreate::class, $match['body']);

    if (in_array('user_id', $properties)) {
        $request_data->user_id = auth();
    }
    return $request_data;
}


function auth(): ?int
{
    $authorization_header = find_authorization_header();
    $token = $authorization_header ? find_token($authorization_header) : null;

    if (!$token){
        return null;
    }

    return (new TokenService())->decode_user_id($token);
}

function set_status_code(string $method): void
{
    switch ($method) {
        case 'GET':
            http_response_code(200);
            break;
        case 'POST':
            http_response_code(201);
            break;
    }
}

function get_body(): ?\stdClass
{
    return json_decode(file_get_contents('php://input'));
}
