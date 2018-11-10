<?php

declare(strict_types=1);

use Factory\VideoFactory;
use DTO\VideoCreate;
use Model\Tag;
use PHPUnit\Framework\TestCase;
use Repository\TagRepository;
use Repository\VideoRepository;
use Service\DatabaseHelper;

class TagControllerTest extends TestCase
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    public static function setUpBeforeClass()
    {
        (new DatabaseHelper())->truncate_all_tables();
    }

    public function setUp()
    {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8000',
        ]);
    }

    /**
     * @test
     * @covers \Controller\TagController::create()
     */
    public function test_create_video_tag()
    {
        $response = $this->create_video_tag();

        $this->assertEquals(201, $response->getStatusCode());
    }

//    /**
//     * @test
//     */
//    public function clear_time_of_video_tag()
//    {
//        $this->create_video_tag();
//
//        $response = $this->client->patch(
//            'api/tags',
//            [
//                'json' => [
//                    'video_tag_id' => 1,
//                ]
//            ]
//        );
//
//        $this->assertEquals(200, $response->getStatusCode());
//    }

    private function create_video_tag(): \Psr\Http\Message\ResponseInterface
    {
        $tag = new Tag('tag name');
        (new TagRepository())->create($tag);

        $artist_name = 'Burak Yeter';
        $video_name = 'Tuesday ft. Danelle Sandoval';
        $youtube_id = 'Y1_VsyLAGuk';

        $video_create = new VideoCreate(
            $artist_name,
            $video_name,
            $youtube_id
        );

        (new VideoFactory())->create($video_create);

        $response = $this->client->post(
            'api/tags',
            [
                'json' => [
                    'youtube_id' => $youtube_id,
                    'tag_name' => $tag->tag_name,
                    'start' => 0,
                    'stop' => 25
                ]
            ]
        );

        return $response;
    }
}
