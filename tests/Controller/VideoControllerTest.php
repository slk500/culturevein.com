<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Repository\Base\Database;
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

    public function setUp()
    {
        $container = new \Container();
        (new DatabaseHelper($container->get(Database::class)))
            ->truncate_all_tables();

        $this->video_repository = $container->get(VideoRepository::class);

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

