<?php

declare(strict_types=1);

namespace Tests\Deleter;

use Container;
use Deleter\VideoTagTimeDeleter;
use DTO\RequestTagVideoTimeCreate;
use Factory\VideoFactory;
use Factory\TagVideoFactory;
use Model\Tag;
use Model\User;
use Repository\Base\Database;
use Repository\History\VideoTagTimeHistoryRepository;
use Repository\TagRepository;
use Repository\UserRepository;
use Repository\TagVideoRepository;
use PHPUnit\Framework\TestCase;
use Repository\TagVideoTimeRepository;
use Tests\DatabaseHelper;
use Tests\Builder\Video\VideoCreateBuilder;
use Tests\Builder\VideoTag\VideoTagCreateBuilder;

class VideoTagTimeDeleterTest extends TestCase
{
    /**
     * @var TagVideoRepository
     */
    private $video_tag_repository;

    /**
     * @var TagVideoTimeRepository
     */
    private $video_tag_time_repository;

    /**
     * @var VideoTagTimeDeleter
     */
    private $video_tag_time_deleter;

    /**
     * @var VideoTagTimeHistoryRepository
     */
    private $video_tag_time_history_repository;

    /**
     * @var UserRepository
     */
    private $user_repository;

    /**
     * @var TagRepository
     */
    private $tag_repository;

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
        $this->video_tag_time_repository = $container->get(TagVideoTimeRepository::class);
        $this->video_tag_time_deleter = $container->get(VideoTagTimeDeleter::class);
        $this->video_tag_time_history_repository= $container->get(VideoTagTimeHistoryRepository::class);
        $this->user_repository = $container->get(UserRepository::class);
        $this->tag_repository = $container->get(TagRepository::class);
        $this->video_factory = $container->get(VideoFactory::class);
        $this->video_tag_factory = $container->get(TagVideoFactory::class);
    }

    /**
     * @test
     * @covers \Deleter\VideoTagTimeDeleter::delete()
     */
    public function ARCHIVE_AND_DELETE_video_tag_time()
    {
        $user = new User('slawomir.grochowski@gmail.com','password', 'slk500');
        $this->user_repository->add($user);

        $tag = new Tag('video game');
        $this->tag_repository->add($tag);

        $video_create = (new VideoCreateBuilder())->build();
        $this->video_factory->create($video_create);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        $this->video_tag_factory->create($video_tag_create);

        $video_tag_time_create = new RequestTagVideoTimeCreate(
            1,
            0,
            10
        );

        $this->video_tag_time_repository->add($video_tag_time_create);

        $video_tags_raw = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);
        $video_tag = end($video_tags_raw);

        $this->assertSame($video_tag_time_create->start, $video_tag['start']);
        $this->assertSame($video_tag_time_create->stop, $video_tag['stop']);

        $this->video_tag_time_deleter->delete(1);

        $video_tags_raw = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);
        $video_tag = end($video_tags_raw);

        $this->assertNull($video_tag['start']);
        $this->assertNull($video_tag['stop']);

        $result = $this->video_tag_time_history_repository->find_all();

        $this->assertNotEmpty($result);
    }
}
