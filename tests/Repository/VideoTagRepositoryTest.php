<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Repository\TagRepository;
use Repository\VideoTagRepository;
use Repository\VideoRepository;
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
        $this->video_tag_repository = new VideoTagRepository();
        (new DatabaseHelper())->truncate_tables([
                'tag',
                'video',
                'video_tag'
            ]
        );
    }

    /**
     * @test
     */
    public function create_video_tag()
    {
        $tag_id = $this->create_tag();

        $video_id = $this->create_video();

        $data = new stdClass();
        $data->tag_id = $tag_id;
        $data->video_id = $video_id;
        $data->start = 0;
        $data->stop = 10;

        $video_tag_id = $this->video_tag_repository->create($data);

        $this->assertSame(1, $video_tag_id);
    }

    /**
     * @test
     */
    public function clear_time()
    {
        $tag_id = $this->create_tag();

        $video_id = $this->create_video();

        $data = new stdClass();
        $data->tag_id = $tag_id;
        $data->video_id = $video_id;
        $data->start = 10;
        $data->stop = 20;

        $video_tag_id = $this->video_tag_repository->create($data);

        $this->video_tag_repository->clear_time($video_tag_id);

        $video_tag = $this->video_tag_repository->find_by_video('VSQjx79dR8s');

        $this->assertNull($video_tag[0]['times']);
    }

    private function create_tag(): int
    {
        $tag_repository = new TagRepository();
        $tag_name = 'tag_name';
        $tag_id = $tag_repository->create($tag_name);
        return $tag_id;
    }

    private function create_video(): int
    {
        $video_repository = new VideoRepository();

        $video_id = $video_repository->create(
            'Yes Sir, I Can Boogie',
            'VSQjx79dR8s');
        return $video_id;
    }
}
