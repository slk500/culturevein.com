<?php

declare(strict_types=1);

function set_slug_as_key($tag)
{
    $result = [];
    $result[$tag['slug']] = $tag;
    return $result;
}

function add_children_field(array $tag)
{
    return array_merge($tag, ['children' => []]);
}

function identity ($value) { return $value; };

function compose(...$functions)
{
    return array_reduce(
        $functions,
        function ($chain, $function) {
            return function ($input) use ($chain, $function) {
                return $function($chain($input));
            };
        },
        'identity'
    );
}