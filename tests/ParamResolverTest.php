<?php

namespace Tests;

use Container;
use Factory\VideoFactory;
use PHPUnit\Framework\TestCase;
use ReflectionFunction;
use ReflectionParameter;



class ParamResolverTest extends TestCase
{
    /**
     * @test
     */
    public function mordo()
    {
        $body = new \stdClass();

        $match = [
            'function' => 'video_create',
            'method' => 'POST',
            'param' => null,
            'body' => $body
        ];


        $reflection_function = new ReflectionFunction($match['function']);

        $parameters = array_map(function (ReflectionParameter $reflection_parameter) {
            return [
                'name' => $reflection_parameter->getName(),
                'type' => ($reflection_parameter->getType())->getName(),
            ];
        }, $reflection_function->getParameters());

        $container = new Container();
        $arguments = array_map(function ($parameter) use($match, $container) {
            if(array_key_exists($parameter['name'], $match['param'])) return $match['param'][$parameter['name']];
            if($parameter['type'] === \stdClass::class) return $match['body'];
            if($parameter['name'] === 'user_id') return null;
            return $container->get($parameter['type']);
        }, $parameters);


    }
}
