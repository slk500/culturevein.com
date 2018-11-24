<?php

declare(strict_types=1);

namespace Tests\Factory;

use Factory\VideoFactory;
use PHPUnit\Framework\TestCase;
use Repository\UserRepository;
use Repository\VideoRepository;
use Service\DatabaseHelper;
use Tests\Builder\User\UserBuilder;
use Tests\Builder\Video\VideoCreateBuilder;

class VideoFactoryTest extends TestCase
{
    /**
     * @var VideoRepository
     */
    private $video_repository;

    public function setUp()
    {
        (new DatabaseHelper())->truncate_all_tables();

        $this->video_repository = new VideoRepository();
    }

    /**
     * @test
     */
    public function create_and_find()
    {
        $user = (new UserBuilder())->build();
        (new UserRepository())->save($user);

        $video_create = (new VideoCreateBuilder())
            ->user_id(1)
            ->build();

        (new VideoFactory())->create($video_create);

        $video = $this->video_repository->find($video_create->youtube_id);

        $this->assertSame($video_create->video_name, $video->video_name);
        $this->assertSame($video_create->artist_name, $video->artist_name);
        $this->assertSame($video_create->youtube_id, $video->video_youtube_id);
        $this->assertSame($video_create->user_id, $video->user_id);
    }
}

