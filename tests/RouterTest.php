<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @test
     */
    public function first_test()
    {
        $match = find_route(include __DIR__ . '/../config/routes.php', '/api/artists', 'GET');
        $this->assertNotEmpty($match);
    }

    /**
     * @test
     */
    public function first_two()
    {
        $match = find_route(include __DIR__ . '/../config/routes.php', '/api/artists/j-lo', 'GET');
        $this->assertNotEmpty($match);
    }

    /**
     * @test
     */
    public function dispatch()
    {
        $match = [
            'function' => 'tag_show',
            'method'=> 'GET',
            'param' => [
                'tag_slug_id' => 'police',
            ]
        ];

        dispatch($match);
    }

    /**
     * @test
     */
    public function route_with_id()
    {
        $result = preg_match('/\/api\/videos\/(?<youtubeId>\w+)/', '/api/videos/YsGk7I5AZBs', $matches);

        $this->assertSame($result, 1);
        $this->assertEquals('YsGk7I5AZBs', $matches['youtubeId']);

        $result = preg_match('/^\/api\/tags\/(?<slug>[\w-]+)\/*$/', '/api/tags/chess', $matches);

        $this->assertSame($result, 1);
        $this->assertEquals('chess', $matches['slug']);

        $result = preg_match('/^\/api\/tags\/(?<slug>[\w-]+)\/*$/', '/api/tags/arnold-schwarzenegger', $matches);

        $this->assertSame($result, 1);
        $this->assertEquals('arnold-schwarzenegger', $matches['slug']);


        $result = preg_match('/^\/api\/videos\/(?<youtubeId>\w{11})\/tags\/*$/', '/api/videos/123456123456/tags', $matches);
        $this->assertSame($result, 0);
    }

    /**
     * @test
     */
    public function route()
    {
        $result = preg_match('/\/api\/tags/', '/api/tags', $matches);
        $this->assertSame($result, 1);
    }
}
