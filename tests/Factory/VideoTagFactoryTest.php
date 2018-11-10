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
    public static function setUpBeforeClass()
    {
        (new DatabaseHelper())->truncate_all_tables();
    }

    /**
     * @test
     */
    public function create()
    {
        $tag = new Tag('tag name');

        (new TagRepository())->create($tag);

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
}
