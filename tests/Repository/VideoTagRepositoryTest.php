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
     * @covers \Repository\VideoTagRepository::is_only_one()
     */
    public function COPY_video_tag_to_another_table()
    {
        $this->markTestSkipped('Behaviour change, fix it later');

        $tag = new Tag('tag name');
        (new TagRepository())->create($tag);

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
     * @covers \Repository\VideoTagRepository::is_only_one()
     */
    public function RETURN_true_IF_only_one_tag_video_exist()
    {
        $tag = new Tag('tag name');
        (new TagRepository())->create($tag);

        $video_create = (new VideoCreateBuilder())->build();
        (new VideoFactory())->create($video_create);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        (new VideoTagFactory())->create($video_tag_create);

        $video_tags = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);

        $this->assertCount(1, $video_tags);

        $video_tag = end($video_tags);

        $result = $this->video_tag_repository->is_only_one($video_tag->video_tag_id);

        $this->assertTrue($result);
    }

    /**
     * @test
     * @covers \Repository\VideoTagRepository::is_only_one()
     */
    public function is_only_one_RETURN_false_IF_more_tag_video_exist()
    {
        $tag = new Tag('tag name');
        (new TagRepository())->create($tag);

        $video_create = (new VideoCreateBuilder())->build();
        (new VideoFactory())->create($video_create);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        (new VideoTagFactory())->create($video_tag_create);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        (new VideoTagFactory())->create($video_tag_create);

        $video_tags = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);

        $this->assertCount(2, $video_tags);

        $video_tag = end($video_tags);

        $result = $this->video_tag_repository->is_only_one($video_tag->video_tag_id);

        $this->assertFalse($result);
    }


    /**
     * @test
     * @covers \Repository\VideoTagRepository::create()
     */
    public function create_video_tag()
    {
        $user = new User('mario@o2.pl','password', 'slk');

        $user_repository = new UserRepository();
        $user_repository->create($user);

        $tag = new Tag('tag name');
        (new TagRepository())->create($tag);

        $video_create = (new VideoCreateBuilder())->build();
        (new VideoFactory())->create($video_create);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        (new VideoTagFactory())->create($video_tag_create);

        $video_tag = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);

        $video_tag = end($video_tag);

        $this->assertSame('tag name', $video_tag->tag_name);
        $this->assertSame(0, $video_tag->start);
        $this->assertSame(20, $video_tag->stop);
        $this->assertSame($video_create->youtube_id, $video_tag->video_youtube_id);
    }

    /**
     * @test
     * @covers \Repository\VideoTagRepository::find()
     */
    public function find()
    {
        $tag = new Tag('tag name');
        (new TagRepository())->create($tag);

        $video_create = (new VideoCreateBuilder())->build();
        (new VideoFactory())->create($video_create);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        (new VideoTagFactory())->create($video_tag_create);

        $video_tag = $this->video_tag_repository->find(1);

        $this->assertInstanceOf(VideoTag::class, $video_tag);
    }
}
