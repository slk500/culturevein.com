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
    private $tagVideoRepository;

    /**
     * @var DatabaseHelper
     */
    private $databaseHelper;

    public static function setUpBeforeClass()
    {
        $databaseHelper = new DatabaseHelper();
        $databaseHelper->truncate_all_tables();
    }

    public function setUp()
    {
        $this->tagVideoRepository = new VideoTagRepository();
        $this->databaseHelper = new DatabaseHelper();
    }

    /**
     * @test
     */
    public function create_video_tag()
    {
        $tagRepository = new TagRepository();
        $tag = new stdClass();
        $tag->name = 'some tag';
        $tagId = $tagRepository->create($tag);

        $videoRepository = new VideoRepository();
        $video = new stdClass();
        $video->name = 'Yes Sir, I Can Boogie';
        $video->youtube_id = 'VSQjx79dR8s';
        $videoId = $videoRepository->create($video);

        $data = new stdClass();
        $data->tag_id = $tagId;
        $data->video_id = $videoId;
        $data->start = 0;
        $data->stop = 10;

        $tagId = $this->tagVideoRepository->create($data);

        $this->assertNotNull($tagId);
    }
}
