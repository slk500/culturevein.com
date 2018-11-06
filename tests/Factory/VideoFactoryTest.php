<?php

declare(strict_types=1);

namespace Tests\Factory;

use Factory\VideoFactory;
use DTO\VideoCreate;
use PHPUnit\Framework\TestCase;
use Repository\ArtistRepository;
use Repository\VideoRepository;
use Repository\VideoTagRepository;
use Service\DatabaseHelper;

class VideoFactoryTest extends TestCase
{
    /**
     * @var VideoRepository
     */
    private $video_repository;

    public static function setUpBeforeClass()
    {
        (new DatabaseHelper())->truncate_all_tables();
    }

    public function setUp()
    {
        (new DatabaseHelper())->truncate_tables([
            'artist',
            'video'
        ]);

        $this->video_repository = new VideoRepository();
    }

    /**
     * @test
     */
    public function create_and_find()
    {
        $artist_name = 'Burak Yeter';
        $video_name = 'Tuesday ft. Danelle Sandoval';
        $youtube_id = 'Y1_VsyLAGuk';

        $video_create = new VideoCreate(
            $artist_name,
            $video_name,
            $youtube_id
        );

        (new VideoFactory())->create($video_create);

        $video = $this->video_repository->find($youtube_id);

        $this->assertSame($video_name, $video->video_name);
        $this->assertSame($artist_name, $video->artist_name);
        $this->assertSame($youtube_id, $video->video_youtube_id);
    }
}
