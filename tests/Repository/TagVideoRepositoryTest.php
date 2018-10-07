<?php

use PHPUnit\Framework\TestCase;
use Repository\TagRepository;
use Repository\TagVideoRepository;
use Repository\VideoRepository;
use Service\DatabaseHelper;

class TagVideoRepositoryTest extends TestCase
{
    /**
     * @var TagVideoRepository
     */
    private $tagVideoRepository;

    /**
     * @var DatabaseHelper
     */
    private $databaseHelper;

    public function setUp()
    {
        $this->tagVideoRepository = new TagVideoRepository();
        $this->databaseHelper = new DatabaseHelper();

        $this->databaseHelper->truncateTables([
            'artist',
            'artist_video',
            'tag',
            'tag_video',
            'tag_video_complete',
            'user',
            'video'
        ]);

        $this->databaseHelper->checkIsAllTablesAreEmpty();

    }

    /**
     * @test
     */
    public function create_video_tag()
    {
        $tagRepository = new TagRepository();
        $tag = new stdClass();
        $tag->name = 'Tag';
        $tagRepository->create($tag);

        $videoRepository = new VideoRepository();
        $video = new stdClass();
        $video->name = 'Video';
        $videoRepository->create($video);

//        $data = new stdClass();
//        $data->tag_id =
//        $data->video_id =
//        $data->start =
//        $data->stop =
//
//        $tagId = $this->tagVideoRepository->create($data);
//
//        $this->assertNotNull($tagId);
    }
}
