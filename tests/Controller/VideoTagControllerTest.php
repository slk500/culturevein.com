<?php

declare(strict_types=1);

use Factory\VideoFactory;
use DTO\VideoCreate;
use Model\Tag;
use PHPUnit\Framework\TestCase;
use Repository\TagRepository;
use Repository\VideoTagRepository;
use Service\DatabaseHelper;

class VideoTagControllerTest extends TestCase
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var VideoTagRepository
     */
    private $video_tag_repository;

    public function setUp()
    {
        (new DatabaseHelper())->truncate_all_tables();

        $this->video_tag_repository = new VideoTagRepository();

        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8000',
        ]);
    }

    /**
     * @test
     */
    public function create_video_tag()
    {
        $tag = new Tag('video game');
        (new TagRepository())->save($tag);

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
            'api/videos/' . $youtube_id . '/tags',
            [
                'json' => [
                    'tag_name' => $tag->tag_name
                ]
            ]
        );

        $result = (new VideoTagRepository())
            ->find_all_for_video($video_create->youtube_id);

        $this->assertNotEmpty($result);

        $video_tag = (end($result));

        $this->assertSame('video game', $tag->tag_name);
        $this->assertSame($video_create->youtube_id, $video_tag->video_youtube_id);

    }
}
