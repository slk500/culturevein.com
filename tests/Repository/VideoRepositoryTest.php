<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Repository\Base\Database;
use Repository\UserRepository;
use Repository\VideoRepository;
use Service\DatabaseHelper;
use Tests\Builder\User\UserBuilder;
use Tests\Builder\Video\VideoCreateBuilder;

class VideoRepositoryTest extends TestCase
{
    /**
     * @var VideoRepository
     */
    private $video_repository;

    /**
     * @var UserRepository
     */
    private $user_repository;

    public function setUp()
    {
        $container = new Container();
        (new DatabaseHelper($container->get(Database::class)))
            ->truncate_all_tables();

        $this->video_repository = $container->get(VideoRepository::class);
        $this->user_repository = $container->get(UserRepository::class);
    }

    /**
     * @test
     */
    public function create_video()
    {
        $video_create = (new VideoCreateBuilder())
            ->build();

        $this->video_repository->save($video_create);

        $video = $this->video_repository->find($video_create->youtube_id);

        $this->assertSame($video_create->video_name, $video->video_name);
        $this->assertSame($video_create->youtube_id, $video->video_youtube_id);
        $this->assertNull($video->user_id);
    }

    /**
     * @test
     */
    public function create_video_with_user_id()
    {
        $user = (new UserBuilder())->build();
        $this->user_repository->save($user);

        $video_create = (new VideoCreateBuilder())
            ->user_id(1)
            ->build();

        $this->video_repository->save($video_create);

        $video = $this->video_repository->find($video_create->youtube_id);

        $this->assertSame($video_create->video_name, $video->video_name);
        $this->assertSame($video_create->youtube_id, $video->video_youtube_id);
        $this->assertSame($video_create->user_id, $video->user_id);
    }
}
