<?php

namespace Tests;

use Container;
use PHPUnit\Framework\TestCase;
use Repository\Base\Database;
use Repository\VideoRepository;

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
    public function konstruktor()
    {
       $database = [new Database()];

       $video_repository = new VideoRepository(...$database);

        $this->assertInstanceOf(VideoRepository::class, $video_repository);
    }
}
