<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Repository\Base\Database;
use Repository\VideoRepository;
use Tests\DatabaseHelper;
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
     * @covers video_create()
     */
    public function create()
    {
        $data = new stdClass();
        $data->artist_name = 'Burak Yeter';
        $data->video_name = 'Tuesday ft. Danelle Sandoval';
        $data->youtube_id = 'Y1_VsyLAGuk';
        $data->duration = 100;

        $response = $this->client->post(
            'api/videos',       [
                'json' => [
                    'artist_name' => $data->artist_name,
                    'video_name' => $data->video_name,
                    'youtube_id' => $data->youtube_id,
                    'duratio' => $data->duration
                ]
            ]
        );

        $x = $response->getBody()->getContents();

        $video = $this->video_repository->find($data->youtube_id);

        $this->assertSame($data->video_name, $video->video_name);
        $this->assertSame($data->youtube_id, $video->video_youtube_id);
    }

    /**
     * @test
     * @covers VideoController::show()
     */
    public function show()
    {
        $video_create = (new VideoCreateBuilder())->build();
        $this->video_repository->add($video_create);

        $response = $this->client->get(
            'api/videos/Y1_VsyLAGuk',
            );

        $result = json_decode($response->getBody()
            ->getContents(),true);

       $this->assertSame($result['data'][0]['video_youtube_id'], 'Y1_VsyLAGuk');
    }
}

