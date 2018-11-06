<?php

declare(strict_types=1);

use DTO\VideoCreate;
use DTO\VideoTagCreate;
use Factory\VideoFactory;
use PHPUnit\Framework\TestCase;
use Repository\TagRepository;
use Repository\VideoTagRepository;
use Service\DatabaseHelper;

class VideoTagRepositoryTest extends TestCase
{
    /**
     * @var VideoTagRepository
     */
    private $video_tag_repository;

    public static function setUpBeforeClass()
    {
        (new DatabaseHelper())->truncate_all_tables();
    }

    public function setUp()
    {
        (new DatabaseHelper())->truncate_tables([
                'tag',
                'video',
                'video_tag'
            ]
        );

        $this->video_tag_repository = new VideoTagRepository();
    }

    /**
     * @test
     */
    public function create_video_tag()
    {
        $tag_name = $tag_slug_id = 'tag';
        (new TagRepository())->create($tag_name, $tag_slug_id);

        $artist_name = 'Burak Yeter';
        $video_name = 'Tuesday ft. Danelle Sandoval';
        $youtube_id = 'Y1_VsyLAGuk';

        $video_create = new VideoCreate(
            $artist_name,
            $video_name,
            $youtube_id
        );

        (new VideoFactory())->create($video_create);

        $start = 0;
        $stop = 20;

        $video_tag_create = new VideoTagCreate(
            $youtube_id,
            $tag_name,
            $start,
            $stop
        );

        $this->video_tag_repository->create($video_tag_create);

        $video_tag = $this->video_tag_repository->find_all_for_video('Y1_VsyLAGuk');

        $this->assertSame('tag', $video_tag[0]['tag_name']);
        $this->assertSame('0-20-1', $video_tag[0]['times']);
        $this->assertSame('Y1_VsyLAGuk', $video_tag[0]['video_youtube_id']);
    }

    /**
     * @test
     */
    public function clear_time()
    {
        $this->create_video_tag();

        $this->video_tag_repository->clear_time(1);

        $video_tag = $this->video_tag_repository->find_all_for_video('Y1_VsyLAGuk');

        $this->assertNull($video_tag[0]['times']);
    }

    private function create_tag(): void
    {
        $tag_name = 'chess';
        $tag_slug_id = 'chess';

        (new TagRepository())->create($tag_name, $tag_slug_id);
    }

    private function create_video(): int
    {
        $artist_name = 'Burak Yeter';
        $video_name = 'Tuesday ft. Danelle Sandoval';
        $youtube_id = 'Y1_VsyLAGuk';

        $video_create = new VideoCreate(
            $artist_name,
            $video_name,
            $youtube_id
        );

        (new VideoFactory())->create($video_create);
    }
}
