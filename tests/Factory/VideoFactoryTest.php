<?php

declare(strict_types=1);

namespace Tests\Factory;

use Container;
use Factory\VideoFactory;
use PHPUnit\Framework\TestCase;
use Repository\Base\Database;
use Repository\UserRepository;
use Repository\VideoRepository;
use Tests\DatabaseHelper;
use Tests\Builder\User\UserBuilder;
use Tests\Builder\Video\VideoCreateBuilder;

class VideoFactoryTest extends TestCase
{
    /**
     * @var VideoRepository
     */
    private $video_repository;

    /**
     * @var UserRepository
     */
    private $user_repository;

    /**
     * @var VideoFactory
     */
    private $video_factory;

    public function setUp()
    {
        $container = new Container();

        (new DatabaseHelper($container->get(Database::class)))
            ->truncate_all_tables();

        $this->video_repository = $container->get(VideoRepository::class);
        $this->video_factory = $container->get(VideoFactory::class);
        $this->user_repository = $container->get(UserRepository::class);
    }

    /**
     * @test
     */
    public function create_and_find()
    {
        $user = (new UserBuilder())->build();
        $this->user_repository->add($user);

        $video_create = (new VideoCreateBuilder())
            ->user_id(1)
            ->build();

        $this->video_factory->create($video_create);

        $video = $this->video_repository->find($video_create->youtube_id);

        $this->assertSame($video_create->video_name, $video->video_name);
        $this->assertSame($video_create->artist_name, $video->artist_name);
        $this->assertSame($video_create->youtube_id, $video->video_youtube_id);
        $this->assertSame($video_create->user_id, $video->user_id);
    }
}

