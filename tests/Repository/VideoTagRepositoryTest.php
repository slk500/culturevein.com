<?php

declare(strict_types=1);

use Factory\VideoFactory;
use Factory\VideoTagFactory;
use Model\Tag;
use Model\User;
use PHPUnit\Framework\TestCase;
use Repository\TagRepository;
use Repository\UserRepository;
use Repository\VideoTagRepository;
use Repository\VideoTagTimeRepository;
use Service\DatabaseHelper;
use Tests\Builder\Video\VideoCreateBuilder;
use Tests\Builder\VideoTag\VideoTagCreateBuilder;
use Tests\Builder\VideoTagTime\VideoTagTimeCreateBuilder;

class VideoTagRepositoryTest extends TestCase
{
    /**
     * @var VideoTagRepository
     */
    private $video_tag_repository;

    private $youtube_id;

    public function setUp()
    {
        (new DatabaseHelper())->truncate_all_tables();

        $this->video_tag_repository = new VideoTagRepository();
    }

    /**
     * @test
     * @covers \Repository\VideoTagRepository::save()
     */
    public function create_video_tag()
    {
        $user = new User('slawomir.grochowski@gmail.com','password', 'slk');

        (new UserRepository())->save($user);

        $video_create = (new VideoCreateBuilder())->build();
        (new VideoFactory())->create($video_create);

        $tag = new Tag('video game');
        (new TagRepository())->save($tag);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        $this->video_tag_repository->save($video_tag_create);

        $video_tag_time_create = (new VideoTagTimeCreateBuilder())->build();
        (new VideoTagTimeRepository())->save($video_tag_time_create);

        $video_tag = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);

        $video_tag = end($video_tag);

        $this->assertSame('video game', $video_tag->tag_name);
        $this->assertSame(0, $video_tag->start);
        $this->assertSame(10, $video_tag->stop);
        $this->assertSame($video_create->youtube_id, $video_tag->video_youtube_id);
    }

    /**
     * @test
     * @covers \Repository\VideoTagRepository::delete()
     */
    public function DELETE_video_tag()
    {
        $user = new User('slawomir.grochowski@gmail.com','password', 'slk');

        (new UserRepository())->save($user);

        $video_create = (new VideoCreateBuilder())->build();
        (new VideoFactory())->create($video_create);

        $tag = new Tag('video game');
        (new TagRepository())->save($tag);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        $this->video_tag_repository->save($video_tag_create);

        $result = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);

        $this->assertNotEmpty($result);

        $this->video_tag_repository->delete($video_create->youtube_id, $tag->tag_slug_id);

        $result = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);

        $this->assertEmpty($result);
    }
}
