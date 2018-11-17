<?php

declare(strict_types=1);

use Controller\TagController;
use Factory\VideoFactory;
use DTO\VideoCreate;
use Model\Tag;
use Model\VideoTag;
use PHPUnit\Framework\TestCase;
use Repository\TagRepository;
use Repository\UserRepository;
use Repository\VideoRepository;
use Repository\VideoTagRepository;
use Service\DatabaseHelper;
use Service\TokenService;
use Tests\Builder\UserBuilder;

class TagControllerTest extends TestCase
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    public function setUp()
    {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8000',
        ]);

        (new DatabaseHelper())->truncate_all_tables();
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


    /**
     * @test
     */
    public function CREATE_video_tag_WHEN_user_login()
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

        $user = (new UserBuilder())->build();

        $user_id = (new UserRepository())->create($user);

        $token = (new TokenService())->create_token($user_id);

        $response = $this->client->post(
            'api/tags' ,
            [
                'json' => [
                    'youtube_id' => $youtube_id,
                    'tag_name' => 'tag_name',
                    'start' => 0,
                    'stop' => 25
                ],
                 'headers' => ['Authorization' => 'Bearer ' . $token],
            ]
        );


        $video_tag_repository = new VideoTagRepository();
        $result = $video_tag_repository->find_all_for_video($video_create->youtube_id);

        $video_tag = (end($result));

        $this->assertSame('tag name', $video_tag->tag_name);
        $this->assertSame(0, $video_tag->start);
        $this->assertSame(25, $video_tag->stop);
        $this->assertSame($video_create->youtube_id, $video_tag->video_youtube_id);
        $this->assertSame($video_tag->user_id, 1);
    }


    private function getDebugQuery()
    {
        $debuggingQuerystring = '';
        if (isset($_GET['XDEBUG_SESSION_START'])) { // xdebug
            $debuggingQuerystring = 'XDEBUG_SESSION_START=' . $_GET['XDEBUG_SESSION_START'];
        }
        if (isset($_COOKIE['XDEBUG_SESSION'])) { // xdebug (cookie)
            $debuggingQuerystring = 'XDEBUG_SESSION_START=PHPSTORM';
        }
        if (isset($_GET['start_debug'])) { // zend debugger
            $debuggingQuerystring = 'start_debug=' . $_GET['start_debug'];
        }
        if (empty($debuggingQuerystring)) {
            $debuggingQuerystring = 'XDEBUG_SESSION_START=PHPSTORM';
        }

        return $debuggingQuerystring;
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
