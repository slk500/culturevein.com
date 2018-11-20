<?php

declare(strict_types=1);

use Factory\VideoFactory;
use Factory\VideoTagFactory;
use Model\Tag;
use Model\User;
use Model\VideoTag;
use PHPUnit\Framework\TestCase;
use Repository\TagRepository;
use Repository\UserRepository;
use Repository\VideoTagRepository;
use Service\DatabaseHelper;
use Tests\Builder\VideoCreateBuilder;
use Tests\Builder\VideoTagCreateBuilder;

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
     * @covers \Repository\VideoTagRepository::create()
     */
    public function create_video_tag()
    {
        $user = new User('mario@o2.pl','password', 'slk');

        (new UserRepository())->create($user);

        $video_create = (new VideoCreateBuilder())->build();
        (new VideoFactory())->create($video_create);

        $tag = new Tag('video game');
        (new TagRepository())->create($tag);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        $this->video_tag_repository->create($video_tag_create);

        $video_tag = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);

        $video_tag = end($video_tag);

        $this->assertSame('video game', $video_tag->tag_name);
        $this->assertSame(0, $video_tag->start);
        $this->assertSame(20, $video_tag->stop);
        $this->assertSame($video_create->youtube_id, $video_tag->video_youtube_id);
    }




    /**
     * @test
     * @covers \Repository\VideoTagRepository::is_only_one()
     */
    public function COPY_video_tag_to_another_table()
    {
        $this->markTestSkipped('Behaviour change, fix it later');

        $video_create = (new VideoCreateBuilder())->build();
        (new VideoFactory())->create($video_create);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        (new VideoTagFactory())->create($video_tag_create);

        $this->video_tag_repository->archive(1);

        $video_tags = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);

        $this->assertCount(0, $video_tags);
    }



    /**
     * @test
     * @covers \Repository\VideoTagRepository::find()
     */
    public function find()
    {
        $video_create = (new VideoCreateBuilder())->build();
        (new VideoFactory())->create($video_create);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        (new VideoTagFactory())->create($video_tag_create);

        $video_tag = $this->video_tag_repository->find(1);

        $this->assertInstanceOf(VideoTag::class, $video_tag);
    }
}
