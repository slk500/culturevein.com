<?php

namespace Tests\Repository\Archiver;

use Factory\VideoFactory;
use Factory\VideoTagFactory;
use Repository\Archiver\ArchiverRepository;
use PHPUnit\Framework\TestCase;
use Repository\ArtistRepository;
use Service\DatabaseHelper;
use Tests\Builder\Video\VideoCreateBuilder;
use Tests\Builder\VideoTag\VideoTagCreateBuilder;

class ArchiverRepositoryTest extends TestCase
{
    /**
     * @var ArtistRepository
     */
    private $artist_repository;

    public static function setUpBeforeClass()
    {
        (new DatabaseHelper())->truncate_all_tables();
    }

    public function setUp()
    {
        $this->artist_repository = new ArtistRepository();
    }

    /**
     * @test
     * @covers \Repository\VideoTagRepository
     */
    public function COPY_video_tag_to_another_table()
    {
        $this->markTestSkipped('Behaviour change, fix it later');

        $video_create = (new VideoCreateBuilder())->build();
        (new VideoFactory())->create($video_create);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        (new VideoTagFactory())->create($video_tag_create);

        $this->video_tag_repository->archive(1);

        $video_tags = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);

        $this->assertCount(0, $video_tags);
    }
}
