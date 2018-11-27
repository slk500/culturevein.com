<?php

declare(strict_types=1);

namespace Tests\Deleter;

use Factory\VideoFactory;
use Factory\VideoTagFactory;
use Model\Tag;
use Model\User;
use Repository\History\VideoTagHistoryRepository;
use Repository\TagRepository;
use Repository\UserRepository;
use Repository\VideoTagRepository;
use Deleter\VideoTagDeleter;
use PHPUnit\Framework\TestCase;
use Service\DatabaseHelper;
use Tests\Builder\Video\VideoCreateBuilder;
use Tests\Builder\VideoTag\VideoTagCreateBuilder;

class VideoTagDeleterTest extends TestCase
{
    /**
     * @var VideoTagRepository
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

    public function setUp()
    {
        $this->video_tag_repository = new VideoTagRepository();
        $this->video_tag_deleter = new VideoTagDeleter();
        $this->video_tag_history_repository= new VideoTagHistoryRepository();

        (new DatabaseHelper())->truncate_all_tables();
    }

    /**
     * @test
     * @covers \Deleter\VideoTagDeleter::delete()
     */
    public function ARCHIVE_AND_DELETE_video_tag()
    {
        $user = new User('slawomir.grochowski@gmail.com','password', 'slk500');
        (new UserRepository())->save($user);

        $tag = new Tag('video game');
        (new TagRepository())->save($tag);

        $video_create = (new VideoCreateBuilder())->build();
        (new VideoFactory())->create($video_create);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        (new VideoTagFactory())->create($video_tag_create);

        $video_tags = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);
        $this->assertCount(1, $video_tags);

        $this->video_tag_deleter->delete($video_tag_create->video_youtube_id, $video_tag_create->tag_slug_id);

        $video_tags = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);
        $this->assertEmpty($video_tags);

        $video_tags = $this->video_tag_history_repository->find_all();
        $this->assertCount(1, $video_tags);
    }
}
