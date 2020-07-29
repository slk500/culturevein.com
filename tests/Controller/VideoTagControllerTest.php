<?php

declare(strict_types=1);

use Controller\VideoTagController;
use Factory\VideoFactory;
use DTO\VideoCreate;
use Model\Tag;
use PHPUnit\Framework\TestCase;
use Repository\Base\Database;
use Repository\TagRepository;
use Repository\VideoTagRepository;
use Tests\DatabaseHelper;

class VideoTagControllerTest extends TestCase
{
    /**
     * @var VideoTagRepository
     */
    private $video_tag_repository;

    /**
     * @var TagRepository
     */
    private $tag_repository;

    /**
     * @var VideoFactory
     */
    private $video_factory;

    public function setUp()
    {
        $container = new \Container();
        (new DatabaseHelper($container->get(Database::class)))
            ->truncate_all_tables();

        $this->video_tag_repository = $container->get(VideoTagRepository::class);
        $this->tag_repository = $container->get(TagRepository::class);
        $this->video_factory = $container->get(VideoFactory::class);
    }

    /**
     * @test
     * @covers VideoTagController::create()
     */
    public function create_video_tag()
    {
        $tag = new Tag('video game');
        $this->tag_repository->add($tag);

        $artist_name = 'Burak Yeter';
        $video_name = 'Tuesday ft. Danelle Sandoval';
        $duration = 10;
        $youtube_id = 'Y1_VsyLAGuk';

        $video_create = new VideoCreate(
            $artist_name,
            $video_name,
            $youtube_id,
            $duration
        );
        $this->video_factory->create($video_create);

        $data = new stdClass();
        $data->tag_name = $tag->name;
        (new VideoTagController())->create($data, $youtube_id);

        $result = $this->video_tag_repository
            ->find_all_for_video($video_create->youtube_id);

        $this->assertNotEmpty($result);

        $video_tag = (end($result));

        $this->assertSame('video game', $tag->name);
        $this->assertSame($video_create->youtube_id, $video_tag['video_youtube_id']);
    }
}
