<?php

use Factory\VideoFactory;
use DTO\VideoCreate;
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
     */
    public function create_video_tag()
    {
        $tag_repository = new TagRepository();
        $tag_name = 'tag';
        $tag_repository->create($tag_name);

        $video_factory = new VideoFactory();

        $video_create = new VideoCreate(
            'Burak Yeter',
            'Tuesday ft. Danelle Sandoval',
            'Y1_VsyLAGuk'
        );

        $video_factory->create($video_create);


        $response = $this->client->post(
          'api/tags',
          [
              'json' => [
                  'video_id' => 1,
                  'name' => 'tag',
                  'start' => 0,
                  'stop' => 25
              ]
          ]
        );

        $this->assertEquals('{"video_id":1,"name":"tag","start":0,"stop":25,"tag_id":1}', $response->getBody()->getContents());
        $this->assertEquals(201, $response->getStatusCode());
    }
}
