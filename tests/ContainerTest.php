<?php

namespace Tests;

use Container;
use PHPUnit\Framework\TestCase;
use Database\Base\Database;
use Database\VideoRepository;

class ContainerTest extends TestCase
{

    /**
     * @test
     */
    public function get()
    {
        $container = new Container();

        $video_repository = $container->get(VideoRepository::class);

        $this->assertInstanceOf(VideoRepository::class, $video_repository);
    }

    /**
     * @test
     */
    public function constructor()
    {
       $database = [new Database()];

       $video_repository = new VideoRepository(...$database);

        $this->assertInstanceOf(VideoRepository::class, $video_repository);
    }
}
