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
