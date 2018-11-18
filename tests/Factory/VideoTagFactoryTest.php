<?php

declare(strict_types=1);

namespace Tests\Factory;

use DTO\VideoTagCreate;
use Factory\VideoTagFactory;
use Factory\VideoFactory;
use DTO\VideoCreate;
use Model\Tag;
use PHPUnit\Framework\TestCase;
use Repository\TagRepository;
use Repository\VideoTagRepository;
use Service\DatabaseHelper;
use Tests\Builder\VideoCreateBuilder;
use Tests\Builder\VideoTagCreateBuilder;

class VideoTagFactoryTest extends TestCase
{
    public function setUp()
    {
        (new DatabaseHelper())->truncate_all_tables();
    }

    /**
     * @test
     */
    public function create()
    {
        $video_create = (new VideoCreateBuilder())->build();
        (new VideoFactory())->create($video_create);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        (new VideoTagFactory())->create($video_tag_create);

        $video_tag_repository = new VideoTagRepository();
        $result = $video_tag_repository->find_all_for_video($video_create->youtube_id);

        $video_tag = (end($result));

        $this->assertSame('tag name', $video_tag->tag_name);
        $this->assertSame(0, $video_tag->start);
        $this->assertSame(20, $video_tag->stop);
        $this->assertSame($video_create->youtube_id, $video_tag->video_youtube_id);
    }

    /**
     * @test
     */
    public function CREATE_video_tag_WHEN_video_tag_with_no_time_already_exist()
    {
        $video_create = (new VideoCreateBuilder())->build();
        (new VideoFactory())->create($video_create);

        $video_tag_create = (new VideoTagCreateBuilder())
            ->stop(null)
            ->start(null)
            ->build();
        (new VideoTagFactory())->create($video_tag_create);

        $video_tag_repository = new VideoTagRepository();
        $result = $video_tag_repository->find_all_for_video($video_create->youtube_id);

        $this->assertCount(1, $result);

        $video_tag = (end($result));

        $this->assertSame('tag name', $video_tag->tag_name);
        $this->assertSame(null, $video_tag->start);
        $this->assertSame(null, $video_tag->stop);
        $this->assertSame($video_create->youtube_id, $video_tag->video_youtube_id);


        $video_tag_create = (new VideoTagCreateBuilder())
            ->start(10)
            ->stop(20)
            ->build();
        (new VideoTagFactory())->create($video_tag_create);

        $result = $video_tag_repository->find_all_for_video($video_create->youtube_id);
        $video_tag = (end($result));

        $this->assertCount(1, $result);

        $this->assertSame('tag name', $video_tag->tag_name);
        $this->assertSame(10, $video_tag->start);
        $this->assertSame(20, $video_tag->stop);
        $this->assertSame($video_create->youtube_id, $video_tag->video_youtube_id);
    }
}
