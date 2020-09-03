<?php

declare(strict_types=1);

namespace Tests\Factory;

use Container;
use Factory\TagVideoFactory;
use Factory\VideoFactory;
use PHPUnit\Framework\TestCase;
use Repository\Base\Database;
use Repository\TagVideoRepository;
use Tests\DatabaseHelper;
use Tests\Builder\Video\VideoCreateBuilder;
use Tests\Builder\VideoTag\VideoTagCreateBuilder;


class VideoTagFactoryTest extends TestCase
{
    /**
     * @var TagVideoRepository
     */
    private $video_tag_repository;

    /**
     * @var VideoFactory
     */
    private $video_factory;

    /**
     * @var TagVideoFactory
     */
    private $video_tag_factory;

    public function setUp()
    {
        $container = new Container();
        (new DatabaseHelper($container->get(Database::class)))
            ->truncate_all_tables();

        $this->video_tag_repository = $container->get(TagVideoRepository::class);
        $this->video_factory = $container->get(VideoFactory::class);
        $this->video_tag_factory = $container->get(TagVideoFactory::class);
    }

    /**
     * @test
     */
    public function create()
    {
        $video_create = (new VideoCreateBuilder())->build();
        $this->video_factory->create($video_create);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        $this->video_tag_factory->create($video_tag_create);

        $result = $this->video_tag_repository
            ->find_all_for_video($video_create->youtube_id);

        $video_tag = (end($result));

        $this->assertSame('video game', $video_tag['tag_name']);
        $this->assertSame($video_create->youtube_id, $video_tag['video_youtube_id']);
    }
}
