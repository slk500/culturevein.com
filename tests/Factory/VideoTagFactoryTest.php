<?php

declare(strict_types=1);

namespace Tests\Factory;

use Factory\VideoTagFactory;
use Factory\VideoFactory;
use PHPUnit\Framework\TestCase;
use Repository\VideoTagRepository;
use Service\DatabaseHelper;
use Tests\Builder\Video\VideoCreateBuilder;
use Tests\Builder\VideoTag\VideoTagCreateBuilder;


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

        $result = (new VideoTagRepository())
            ->find_all_for_video($video_create->youtube_id);

        $video_tag = (end($result));

        $this->assertSame('video game', $video_tag->tag_name);
        $this->assertSame($video_create->youtube_id, $video_tag->video_youtube_id);
    }
}
