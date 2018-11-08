<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Repository\TagRepository;
use Repository\VideoTagRepository;
use Service\DatabaseHelper;
use Tests\Builder\VideoBuilder;
use Tests\Builder\VideoTagBuilder;

class VideoTagRepositoryTest extends TestCase
{
    /**
     * @var VideoTagRepository
     */
    private $video_tag_repository;

    private $youtube_id;

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

        $this->youtube_id = 'Y1_VsyLAGuk';
    }

    /**
     * @test
     */
    public function create_video_tag()
    {
        $tag_name = $tag_slug_id = 'tag';
        (new TagRepository())->create($tag_name, $tag_slug_id);

        (new VideoBuilder())
            ->youtube_id($this->youtube_id)
            ->artist_name('Burak Yeter')
            ->video_name('Tuesday ft. Danelle Sandoval')
            ->build();


        (new VideoTagBuilder())
            ->youtube_id($this->youtube_id)
            ->tag_name('tag')
            ->start(0)
            ->stop(20)
            ->build();

        $video_tag = $this->video_tag_repository->find_all_for_video($this->youtube_id);

        $this->assertSame('tag', $video_tag[0]['tag_name']);
        $this->assertSame(0, $video_tag[0]['start']);
        $this->assertSame(20, $video_tag[0]['stop']);
        $this->assertSame($this->youtube_id, $video_tag[0]['video_youtube_id']);
    }

    /**
     * @test
     * @depends create_video_tag
     * @info it will set times to null not delete it
     */
    public function delete_last_video_tag_with_times()
    {
        $this->create_video_tag();

        $video_tag = $this->video_tag_repository->find_all_for_video($this->youtube_id);

        $this->assertSame(0, $video_tag[0]['start']);
        $this->assertSame(20, $video_tag[0]['stop']);

        $this->video_tag_repository->delete(1);

        $video_tag = $this->video_tag_repository->find_all_for_video($this->youtube_id);

        $this->assertSame('tag', $video_tag[0]['tag_name']);
        $this->assertNull($video_tag[0]['start']);
        $this->assertNull($video_tag[0]['stop']);
        $this->assertSame($this->youtube_id, $video_tag[0]['video_youtube_id']);
    }
}
