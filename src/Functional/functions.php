<?php

declare(strict_types=1);

function set_slug_as_key($tag)
{
    $result = [];
    $result[$tag['tag_slug_id']] = $tag;
    return $result;
}

function add_children_field(array $tag)
{
    return array_merge($tag, ['children' => []]);
}

function add_count_field(array $tag)
{
    return array_merge($tag, ['count' => 0]);
}

function compose(...$functions)
{
    return array_reduce(
        $functions,
        function ($chain, $function) {
            return function ($input) use ($chain, $function) {
                return $function($chain($input));
            };
        },
        fn($value) => $value
    );
}

function find_token(string $token): ?string
{
   $result = explode("Bearer ",$token);
   return $result[1] ?? null;
}

function find_authorization_header(): ?string
{
    return get_all_headers()['Authorization'] ?? null;
}

//function exist only in apache not nginx
//todo no need to foreach and take all headers, take only autohorization
function get_all_headers()
{
    $headers = array();
    foreach ($_SERVER as $name => $value) {
        if (substr($name, 0, 5) == 'HTTP_') {
            $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
        }
    }
    return $headers;
}

function recast($className, array $arguments): object
{
    if (!class_exists($className))
        throw new InvalidArgumentException(sprintf('Inexistant class %s.', $className));

    $new = new $className();
    foreach ($arguments as $property => $value) {
        $new->$property = $value;
    }

    return $new;
}