<?php

declare(strict_types=1);

use Factory\VideoFactory;
use DTO\VideoCreate;
use Factory\TagVideoFactory;
use Model\Tag;
use PHPUnit\Framework\TestCase;
use Repository\Base\Database;
use Repository\TagRepository;
use Repository\VideoTagRepository;
use Tests\DatabaseHelper;
use Tests\Builder\Video\VideoCreateBuilder;
use Tests\Builder\VideoTag\VideoTagCreateBuilder;

class VideoTagTimeControllerTest extends TestCase
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var VideoTagRepository
     */
    private $video_tag_repository;

    /**
     * @var VideoFactory
     */
    private $video_factory;

    /**
     * @var TagVideoFactory
     */
    private $video_tag_factory;

    public function setUp()
    {
        $container = new \Container();
        (new DatabaseHelper($container->get(Database::class)))
            ->truncate_all_tables();

        $this->video_tag_repository = $container->get(VideoTagRepository::class);
        $this->video_tag_factory = $container->get(TagVideoFactory::class);
        $this->video_factory = $container->get(VideoFactory::class);


        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8000',
        ]);
    }

    /**
     * @test
     * @covers VideoTagTimeController::create()
     */
    public function CREATE_video_tag_time()
    {
        $video_create = (new VideoCreateBuilder())->build();
        $this->video_factory->create($video_create);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        $this->video_tag_factory->create($video_tag_create);

        $this->client->post(
            'api/videos/' . $video_tag_create->video_youtube_id . '/tags/' . $video_tag_create->tag_slug_id,
            [
                'json' => [
                    'start' => 0,
                    'stop' => 10
                ]
            ]
        );

        $result = $this->video_tag_repository
            ->find_all_for_video($video_create->youtube_id);

        $this->assertNotEmpty($result);

        $video_tag_raw = (end($result));

        $this->assertSame('video game', $video_tag_raw['tag_name']);
        $this->assertSame($video_create->youtube_id, $video_tag_raw['video_youtube_id']);
        $this->assertSame(0, $video_tag_raw['start']);
        $this->assertSame(10, $video_tag_raw['stop']);
    }

    /**
     * @test
     */
    public function TRY_CREATE_video_tag_time_WHEN_video_tag_NOT_EXIST()
    {
        $this->markTestSkipped('to do - throw some error or something');

        $video_create = (new VideoCreateBuilder())->build();
        $this->video_factory->create($video_create);


        $response = $this->client->post(
            'api/videos/' . $video_create->youtube_id . '/tags/' . 'video-game',
            [
                'json' => [
                    'start' => 0,
                    'stop' => 10
                ]
            ]
        );


        $this->assertSame('',$response->getBody()->getContents());
    }
}
