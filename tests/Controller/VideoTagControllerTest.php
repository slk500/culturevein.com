<?php

declare(strict_types=1);

use Controller\VideoTagController;
use Factory\VideoFactory;
use DTO\VideoCreate;
use Factory\VideoTagFactory;
use Model\Tag;
use PHPUnit\Framework\TestCase;
use Repository\TagRepository;
use Repository\VideoRepository;
use Repository\VideoTagRepository;
use Service\DatabaseHelper;
use Tests\Builder\VideoCreateBuilder;
use Tests\Builder\VideoTagCreateBuilder;

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
     * @covers \Deleter\VideoTagDeleter::delete()
     */
    public function ARCHIVE_AND_SET_time_range_null_IF_only_one_video_tag_exist_and_time_range_is_not_null()
    {
        $tag = new Tag('tag name');

        (new TagRepository())->create($tag);

        $video_create = (new VideoCreateBuilder())->build();
        (new VideoFactory())->create($video_create);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        (new VideoTagFactory())->create($video_tag_create);

        $result = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);
        $video_tag = end($result);

        $this->assertSame(0, $video_tag->start);
        $this->assertSame(20, $video_tag->stop);

        $response = $this->client->get(
            'api/videos/' . $video_create->youtube_id . '/tags/1'

        );

        $result = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);
        $video_tag_after_delete = end($result);

        $this->assertNull($video_tag_after_delete->start);
        $this->assertNull($video_tag_after_delete->stop);
    }


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
