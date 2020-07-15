<?php

declare(strict_types=1);

use DTO\VideoTagTimeCreate;
use Factory\VideoFactory;
use Model\Tag;
use PHPUnit\Framework\TestCase;
use Repository\Base\Database;
use Repository\TagRepository;
use Repository\VideoTagRepository;
use Repository\VideoTagTimeRepository;
use Tests\DatabaseHelper;
use Tests\Builder\Video\VideoCreateBuilder;
use Tests\Builder\VideoTag\VideoTagCreateBuilder;

class VideoTagTimeRepositoryTest extends TestCase
{
    /**
     * @var VideoTagRepository
     */
    private $video_tag_repository;

    /**
     * @var VideoTagTimeRepository
     */
    private $video_tag_time_repository;

    /**
     * @var VideoFactory
     */
    private $video_factory;

    /**
     * @var TagRepository
     */
    private $tag_repository;

    private $youtube_id;

    public function setUp()
    {
        $container = new Container();
        (new DatabaseHelper($container->get(Database::class)))
            ->truncate_all_tables();

        $this->video_tag_repository = $container->get(VideoTagRepository::class);
        $this->video_factory = $container->get(VideoFactory::class);
        $this->tag_repository = $container->get(TagRepository::class);
        $this->video_tag_time_repository = $container->get(VideoTagTimeRepository::class);
    }

    /**
     * @test
     * @covers \Repository\VideoTagTimeRepository::save()
     */
    public function save()
    {
        $video_create = (new VideoCreateBuilder())->build();
        $this->video_factory->create($video_create);

        $tag = new Tag('video game');
        $this->tag_repository->save($tag);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        $this->video_tag_repository->save($video_tag_create);

        $video_tag_time_create = new VideoTagTimeCreate(1,0,10);

        $this->video_tag_time_repository->save($video_tag_time_create);

        $video_tag = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);

        $video_tag = end($video_tag);

        $this->assertSame('video game', $video_tag['tag_name']);
        $this->assertSame(0, $video_tag['start']);
        $this->assertSame(10, $video_tag['stop']);
        $this->assertSame($video_create->youtube_id, $video_tag['video_youtube_id']);
    }
}
