<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Repository\VideoRepository;
use Service\DatabaseHelper;

class VideoControllerTest extends TestCase
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var VideoRepository
     */
    private $video_repository;

    public static function setUpBeforeClass()
    {
        $databaseHelper = new DatabaseHelper();

        $databaseHelper->truncate_all_tables();
    }


    public function setUp()
    {
        $this->video_repository = new VideoRepository();

        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8000',
        ]);

    }

    /**
     * @test
     * @covers VideoController::create()
     */
    public function create_video()
    {
        $json = [
            'artist' => 'Burak Yeter',
            'name' => 'Tuesday ft. Danelle Sandoval',
            'youtube_id' => 'Y1_VsyLAGuk'
        ];

        $response = $this->client->post(
            'api/videos',
            [
                'json' => $json
            ]
        );

        $this->assertEquals(201,$response->getStatusCode());

        $video = $this->video_repository->find($json['youtube_id']);

        $this->assertSame($json['name'], $video->video_name);
        $this->assertSame($json['youtube_id'], $video->video_youtube_id);
    }
}

