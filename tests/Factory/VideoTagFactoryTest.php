<?php

declare(strict_types=1);

namespace Tests\Factory;

use DTO\VideoTagCreate;
use Factory\VideoTagFactory;
use Factory\VideoFactory;
use DTO\VideoCreate;
use PHPUnit\Framework\TestCase;
use Repository\TagRepository;
use Repository\VideoTagRepository;
use Service\DatabaseHelper;

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
        $tag_name = $tag_slug_id = 'tag';
        (new TagRepository())->create($tag_name, $tag_slug_id);

        $artist_name = 'Burak Yeter';
        $video_name = 'Tuesday ft. Danelle Sandoval';
        $youtube_id = 'Y1_VsyLAGuk';

        $video_create = new VideoCreate(
            $artist_name,
            $video_name,
            $youtube_id
        );

        (new VideoFactory())->create($video_create);

        $video_tag_factory = new VideoTagFactory();

        $start = 0;
        $stop = 20;

        $video_tag_create = new VideoTagCreate(
            $youtube_id,
            $tag_name,
            $start,
            $stop
        );

        $video_tag_factory->create($video_tag_create);

        $video_tag_repository = new VideoTagRepository();

        $result = $video_tag_repository->find_all_for_video($youtube_id);

        $video_tag = (end($result));

        $expected = [
            'tag_name' => 'tag',
            'video_youtube_id' => 'Y1_VsyLAGuk',
            'start' => 0,
            'stop' => 20,
            'tag_slug_id' => 'tag',
            'complete' => 0
        ];

        $this->assertSame($expected, $video_tag);
    }
}
