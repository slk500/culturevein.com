<?php

declare(strict_types=1);

namespace Tests\Deleter;

use Deleter\VideoTagTimeDeleter;
use DTO\VideoTagRaw;
use Factory\VideoFactory;
use Factory\VideoTagFactory;
use Model\Tag;
use Model\User;
use Repository\History\VideoTagTimeHistoryRepository;
use Repository\TagRepository;
use Repository\UserRepository;
use Repository\VideoTagRepository;
use PHPUnit\Framework\TestCase;
use Repository\VideoTagTimeRepository;
use Service\DatabaseHelper;
use Tests\Builder\Video\VideoCreateBuilder;
use Tests\Builder\VideoTag\VideoTagCreateBuilder;
use Tests\Builder\VideoTagTime\VideoTagTimeCreateBuilder;

class VideoTagTimeDeleterTest extends TestCase
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
     * @var VideoTagTimeDeleter
     */
    private $video_tag_time_deleter;

    /**
     * @var VideoTagTimeHistoryRepository
     */
    private $video_tag_time_history_repository;

    public function setUp()
    {
        $this->video_tag_repository = new VideoTagRepository();
        $this->video_tag_time_repository = new VideoTagTimeRepository();
        $this->video_tag_time_deleter = new VideoTagTimeDeleter();
        $this->video_tag_time_history_repository= new VideoTagTimeHistoryRepository();

        (new DatabaseHelper())->truncate_all_tables();
    }

    /**
     * @test
     * @covers \Deleter\VideoTagTimeDeleter::delete()
     */
    public function ARCHIVE_AND_DELETE_video_tag_time()
    {
        $user = new User('slawomir.grochowski@gmail.com','password', 'slk500');
        (new UserRepository())->save($user);

        $tag = new Tag('video game');
        (new TagRepository())->save($tag);

        $video_create = (new VideoCreateBuilder())->build();
        (new VideoFactory())->create($video_create);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        (new VideoTagFactory())->create($video_tag_create);

        $video_tag_time_create = (new VideoTagTimeCreateBuilder())->build();

        $this->video_tag_time_repository->save($video_tag_time_create);

        $video_tags_raw = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);
        $video_tag = end($video_tags_raw);

        $this->assertInstanceOf(VideoTagRaw::class, $video_tag);
        $this->assertSame($video_tag_time_create->start,$video_tag->start);
        $this->assertSame($video_tag_time_create->stop,$video_tag->stop);

        $this->video_tag_time_deleter->delete(1);

        $video_tags_raw = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);
        $video_tag = end($video_tags_raw);

        $this->assertInstanceOf(VideoTagRaw::class, $video_tag);
        $this->assertNull($video_tag->start);
        $this->assertNull($video_tag->stop);

        $result = $this->video_tag_time_history_repository->find_all();

        $this->assertNotEmpty($result);
    }
}
