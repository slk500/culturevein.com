<?php

declare(strict_types=1);

use Factory\VideoFactory;
use Factory\VideoTagFactory;
use Model\Tag;
use PHPUnit\Framework\TestCase;
use Repository\TagRepository;
use Repository\VideoTagRepository;
use Service\DatabaseHelper;
use Tests\Builder\VideoCreateBuilder;
use Tests\Builder\VideoTagCreateBuilder;

class VideoTagRepositoryTest extends TestCase
{
    /**
     * @var VideoTagRepository
     */
    private $video_tag_repository;

    private $youtube_id;

    public static function setUpBeforeClass()
    {
        (new DatabaseHelper())->truncate_all_tables();
    }

    public function setUp()
    {
        (new DatabaseHelper())->truncate_tables([
                'tag',
                'video',
                'video_tag'
            ]
        );

        $this->video_tag_repository = new VideoTagRepository();

    }

    /**
     * @test
     */
    public function create_video_tag()
    {
        $tag = new Tag('tag name');
        (new TagRepository())->create($tag);

        $video_create = (new VideoCreateBuilder())->build();
        (new VideoFactory())->create($video_create);


        $video_tag_create = (new VideoTagCreateBuilder())->build();
        (new VideoTagFactory())->create($video_tag_create);

        $video_tag = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);

        $video_tag = end($video_tag);

        $this->assertSame('tag name', $video_tag->tag_name);
        $this->assertSame(0, $video_tag->start);
        $this->assertSame(20, $video_tag->stop);
        $this->assertSame($video_create->youtube_id, $video_tag->video_youtube_id);
    }
}
