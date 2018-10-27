<?php

declare(strict_types=1);

namespace Tests\Factory;

use Factory\VideoFactory;
use DTO\VideoCreate;
use PHPUnit\Framework\TestCase;
use Service\DatabaseHelper;

class VideoFactoryTest extends TestCase
{
    public static function setUpBeforeClass()
    {
        (new DatabaseHelper())->truncate_all_tables();
    }

    public function setUp()
    {
        $this->markTestSkipped('Check in database');

        (new DatabaseHelper())->truncate_tables([
            'artist',
            'video'
        ]);
    }

    /**
     * @test
     */
    public function create()
    {
        $video_factory = new VideoFactory();

        $video_create = new VideoCreate(
            'Burak Yeter',
            'Tuesday ft. Danelle Sandoval',
            'Y1_VsyLAGuk'
        );

        $video_factory->create($video_create);
    }

    /**
     * @test
     */
    public function create_try_without_artist_name()
    {
        $video_factory = new VideoFactory();

        $video_create = new VideoCreate(
            null,
            'Tuesday ft. Danelle Sandoval',
            'Y1_VsyLAGuk'
        );

        $video_factory->create($video_create);
    }
}
