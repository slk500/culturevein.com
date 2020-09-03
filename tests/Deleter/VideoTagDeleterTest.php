<?php

declare(strict_types=1);

namespace Tests\Deleter;

use Container;
use Factory\VideoFactory;
use Factory\TagVideoFactory;
use Model\Tag;
use Model\User;
use Repository\Base\Database;
use Repository\History\VideoTagHistoryRepository;
use Repository\TagRepository;
use Repository\UserRepository;
use Repository\TagVideoRepository;
use Deleter\VideoTagDeleter;
use PHPUnit\Framework\TestCase;
use Tests\DatabaseHelper;
use Tests\Builder\Video\VideoCreateBuilder;
use Tests\Builder\VideoTag\VideoTagCreateBuilder;

class VideoTagDeleterTest extends TestCase
{
    /**
     * @var TagVideoRepository
     */
    private $video_tag_repository;

    /**
     * @var VideoTagDeleter
     */
    private $video_tag_deleter;

    /**
     * @var VideoTagHistoryRepository
     */
    private $video_tag_history_repository;

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
        $this->video_tag_deleter = $container->get(VideoTagDeleter::class);
        $this->video_tag_history_repository = $container->get(VideoTagHistoryRepository::class);
        $this->user_repository = $container->get(UserRepository::class);
        $this->tag_repository = $container->get(TagRepository::class);
        $this->video_factory = $container->get(VideoFactory::class);
        $this->video_tag_factory = $container->get(TagVideoFactory::class);
    }

    /**
     * @test
     * @covers \Deleter\VideoTagDeleter::delete()
     */
    public function ARCHIVE_AND_DELETE_video_tag()
    {
        $user = new User('slawomir.grochowski@gmail.com','password', 'slk500');
        $this->user_repository->add($user);

        $tag = new Tag('video game');
        $this->tag_repository->add($tag);

        $video_create = (new VideoCreateBuilder())->build();
        $this->video_factory->create($video_create);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        $this->video_tag_factory->create($video_tag_create);

        $video_tags = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);
        $this->assertCount(1, $video_tags);

        $this->video_tag_deleter->delete($video_tag_create->video_youtube_id, $video_tag_create->tag_slug_id);

        $video_tags = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);
        $this->assertEmpty($video_tags);

        $video_tags = $this->video_tag_history_repository->find_all();
        $this->assertCount(1, $video_tags);
    }
}
