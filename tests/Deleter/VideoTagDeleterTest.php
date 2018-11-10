<?php

declare(strict_types=1);

namespace Tests\Deleter;

use Factory\VideoFactory;
use Factory\VideoTagFactory;
use Repository\TagRepository;
use Repository\VideoTagRepository;
use Tests\Builder\VideoCreateBuilder;
use Tests\Builder\VideoTagCreateBuilder;
use Deleter\VideoTagDeleter;
use PHPUnit\Framework\TestCase;
use Service\DatabaseHelper;

class VideoTagDeleterTest extends TestCase
{
    /**
     * @var VideoTagRepository
     */
    private $video_tag_repository;

    public static function setUpBeforeClass()
    {
        (new DatabaseHelper())->truncate_all_tables();
    }

    public function setUp()
    {
        $this->video_tag_repository = new VideoTagRepository();
    }

    /**
     * @test
     * @covers \Deleter\VideoTagDeleter::delete()
     */
    public function delete_video_tag_IF_two_exist()
    {

    }

    public function delete_video_tag_IF_start_and_stop_are_null()
    {

    }

    /**
     * @test
     */
    public function delete_would_set_start_and_stop_as_null_IF_video_tag_is_last_and_start_and_stop_is_not_null()
    {
        $tag_name = 'tag name';
        $tag_slug_id = 'tag-name';

        (new TagRepository())->create($tag_name, $tag_slug_id);

        $video_create = (new VideoCreateBuilder())->build();
        (new VideoFactory())->create($video_create);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        (new VideoTagFactory())->create($video_tag_create);

        $result = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);
        $video_tag = end($result);

        $this->assertSame(0, $video_tag->start);
        $this->assertSame(20, $video_tag->stop);

        $videoTagDeleter = new VideoTagDeleter();
        $videoTagDeleter->delete($video_tag->video_tag_id);

        $result = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);
        $video_tag_after_delete = end($result);

        $this->assertNull($video_tag_after_delete->start);
        $this->assertNull($video_tag_after_delete->stop);
    }
}
