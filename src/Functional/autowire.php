<?php

declare(strict_types=1);

use ApiProblem\ApiProblem;
use DTO\RequestData;

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