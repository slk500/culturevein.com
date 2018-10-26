<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Repository\TagRepository;
use Repository\VideoTagRepository;
use Repository\VideoRepository;
use Service\DatabaseHelper;

class VideoTagRepositoryTest extends TestCase
{
    /**
     * @var VideoTagRepository
     */
    private $video_tag_repository;

    /**
     * @var DatabaseHelper
     */
    private $database_helper;

    public static function setUpBeforeClass()
    {
        (new DatabaseHelper())->truncate_all_tables();
    }

    public function setUp()
    {
        $this->video_tag_repository = new VideoTagRepository();
        $this->database_helper = new DatabaseHelper();
    }

    /**
     * @test
     */
    public function create_video_tag()
    {
        $tag_repository = new TagRepository();
        $tag_name = 'tag_name';
        $tag_id = $tag_repository->create($tag_name);

        $video_repository = new VideoRepository();
        $video = new stdClass();
        $video->name = 'Yes Sir, I Can Boogie';
        $video->youtube_id = 'VSQjx79dR8s';
        $video_id = $video_repository->create($video);

        $data = new stdClass();
        $data->tag_id = $tag_id;
        $data->video_id = $video_id;
        $data->start = 0;
        $data->stop = 10;

        $video_tag_id = $this->video_tag_repository->create($data);

        $this->assertSame(1, $video_tag_id);
    }
}
