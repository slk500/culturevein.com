<?php

declare(strict_types=1);

namespace Tests\Factory;

use Factory\VideoFactory;
use PHPUnit\Framework\TestCase;
use Service\DatabaseHelper;

class VideoFactoryTest extends TestCase
{
    public static function setUpBeforeClass()
    {
        $databaseHelper = new DatabaseHelper();
        $databaseHelper->truncate_all_tables();
    }

    /**
     * @test
     */
    public function create()
    {
        $video_factory = new VideoFactory();

        $data = new \stdClass();
        $data->artist = 'Burak Yeter';
        $data->name = 'Tuesday ft. Danelle Sandoval';
        $data->youtube_id = 'Y1_VsyLAGuk';

        $result = $video_factory->create($data);

        $this->assertEquals(1, $result->artist_id);
        $this->assertEquals(1, $result->video_id);
    }
}
