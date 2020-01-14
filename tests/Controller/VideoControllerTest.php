<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Repository\Base\Database;
use Repository\VideoRepository;
use Service\DatabaseHelper;
use Tests\Builder\Video\VideoCreateBuilder;

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
    public function create()
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

    /**
     * @test
     * @covers VideoController::show()
     */
    public function show()
    {
        $video_create = (new VideoCreateBuilder())->build();
        $this->video_repository->save($video_create);

        $response = $this->client->get(
            'api/videos/Y1_VsyLAGuk',
            );

        $result = json_decode($response->getBody()
            ->getContents(),true);

       $this->assertSame($result['data'][0]['video_youtube_id'], 'Y1_VsyLAGuk');
    }
}

