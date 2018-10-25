<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Repository\VideoRepository;

class VideoRepositoryTest extends TestCase
{
    /**
     * @var VideoRepository
     */
    private $videoRepository;

    public function setUp()
    {
        $this->videoRepository = new VideoRepository();
    }

    /**
     * @test
     */
    public function create_video()
    {
        $video = new stdClass();
        $video->name = 'Yes Sir, I Can Boogie';
        $video->youtube_id = 'VSQjx79dR8s';
        $video->artist_name = 'Boccara';

        $tagId = $this->videoRepository->create($video);

        $this->assertNotNull($tagId);
    }
}
