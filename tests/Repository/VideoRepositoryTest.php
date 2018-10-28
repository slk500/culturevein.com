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
        (new DatabaseHelper())->truncate_all_tables();
    }

    /**
     * @test
     */
    public function create_video()
    {
        $video_id = $this->video_repository->create(
            'Yes Sir, I Can Boogie',
            'VSQjx79dR8s');

        $this->assertSame(1, $video_id);
    }

    /**
     * @test
     */
    public function find_video()
    {
        $this->video_repository->create(
            'Yes Sir, I Can Boogie',
            'VSQjx79dR8s');

        $video = $this->video_repository->find('VSQjx79dR8s');

        $expected = [
            [
                'video_name' => 'Yes Sir, I Can Boogie',
                'release_date' => null,
                'youtube_id' => 'VSQjx79dR8s',
                'duration' => 272,
                'artist_name' => null,
                'video_id' => 1,
            ]
        ];

        $this->assertSame($expected, $video);
    }
}
