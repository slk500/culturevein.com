<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Repository\VideoRepository;
use Service\DatabaseHelper;

class VideoRepositoryTest extends TestCase
{
    /**
     * @var VideoRepository
     */
    private $video_repository;

    public static function setUpBeforeClass()
    {
        (new DatabaseHelper())->truncate_all_tables();
    }

    public function setUp()
    {
        $this->video_repository = new VideoRepository();
    }

    /**
     * @test
     */
    public function create_video()
    {
        $youtube_id = 'VSQjx79dR8s';
        $video_name =  'Yes Sir, I Can Boogie';

        $this->video_repository->create(
            $video_name,
            $youtube_id
        );

        $video = $this->video_repository->find($youtube_id);

        $this->assertSame($video_name, $video->video_name);
        $this->assertSame($youtube_id, $video->video_youtube_id);
    }
}
