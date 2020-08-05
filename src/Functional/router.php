<?php

declare(strict_types=1);

use ApiProblem\ApiProblem;

function match(array $routes, string $url, string $method): ?array
{
    foreach ($routes as $route) {
        if (preg_match($route[0], $url, $matches) &&
            ($route[2] === $method || $method == 'OPTIONS')) {

            return [
                'function' => $route[1],
                'method' => $route[2],
                'param' => $matches
            ];
        }
    }
    return null;
}

function dispatch(array $match): void
{
    $container = new Container();

    $ref = new ReflectionFunction($match['function']);

    $parameters = array_map(function (ReflectionParameter $reflection_parameter) {
        return [
            'name' => $reflection_parameter->getName(),
            'type' => ($reflection_parameter->getType())->getName(),
        ];
    }, $ref->getParameters());

    $arguments = array_map(function ($parameter) use($match, $container) {
        if(array_key_exists($parameter['name'], $match['param'])) return $match['param'][$parameter['name']];
        return $container->get($parameter['type']);
    }, $parameters);

    $result = call_user_func_array($match['function'], $arguments);

    echo json_encode(['data' => $result]);

//    $authorization_header = find_authorization_header();
//    $token = $authorization_header ? find_token($authorization_header) : null;
//
//    if ($token) $controller->authentication($token);
//
//    $actionName = $match['action'];
//
//    try {
//        $param1 = $match['param'][1] ?? null;
//        $param2 = $match['param'][2] ?? null;
//        if ($match['method'] == 'POST') {
//            $result = $controller->$actionName(get_body(), $param1, $param2);
//        } else {
//            $param3 = $match['param'][3] ?? null;
//            $result = $controller->$actionName($param1, $param2, (int)$param3);
//        }
//
//        set_status_code($match['method']);
//        echo json_encode(['data' => $result]);
//
//    } catch (ApiProblem $apiProblem) {
//        http_response_code($apiProblem->getCode());
//        echo json_encode($apiProblem->getMessage());
//    } catch (\Throwable $throwable) {
//        http_response_code(500);
//        echo json_encode($throwable->getMessage());
//    }
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
