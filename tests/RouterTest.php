<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @test
     */
    public function straight_regex()
    {
        $router = new \Router();

        $router->add('/^\/api\/tags\/*$/',['controller' => 'TagController', 'action' => 'list']);

        $this->assertTrue($router->match('/api/tags'));

        $router = new \Router();

        $router->add('/^\/api\/tags\/(?<slug>\w+)\/*$/',['controller' => 'TagController', 'action' => 'list']);

        $this->assertTrue($router->match('/api/tags/chess'));

        $router = new \Router();

        $router->add('/^\/api\/tags-top\/*$/',['controller' => 'TagController', 'action' => 'list']);

        $this->assertTrue($router->match('/api/tags-top'));
    }


    /**
     * @test
     */
    public function route_with_id()
    {
        $result = preg_match('/\/api\/videos\/(?<youtubeId>\w+)/','/api/videos/YsGk7I5AZBs', $matches);

        $this->assertSame($result, 1);
        $this->assertEquals('YsGk7I5AZBs', $matches['youtubeId']);

        $result = preg_match('/^\/api\/tags\/(?<slug>[\w-]+)\/*$/','/api/tags/chess', $matches);

        $this->assertSame($result, 1);
        $this->assertEquals('chess', $matches['slug']);

        $result = preg_match('/^\/api\/tags\/(?<slug>[\w-]+)\/*$/','/api/tags/arnold-schwarzenegger', $matches);

        $this->assertSame($result, 1);
        $this->assertEquals('arnold-schwarzenegger', $matches['slug']);


        $result = preg_match('/^\/api\/videos\/(?<youtubeId>\w{11})\/tags\/*$/','/api/videos/123456123456/tags', $matches);
        $this->assertSame($result, 0);
    }

    /**
     * @test
     */
    public function route()
    {
        $result = preg_match('/\/api\/tags/','/api/tags', $matches);
        $this->assertSame($result, 1);
    }
}
