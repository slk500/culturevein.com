<?php

declare(strict_types=1);

namespace Tests\Factory;

use Factory\VideoTagFactory;
use Factory\VideoFactory;
use PHPUnit\Framework\TestCase;
use Repository\TagRepository;
use Repository\VideoRepository;
use Service\DatabaseHelper;
use stdClass;

class VideoTagFactoryTest extends TestCase
{
    public static function setUpBeforeClass()
    {
        $databaseHelper = new DatabaseHelper();
        $databaseHelper->truncate_all_tables();
    }

    /**
     * @test
     */
    public function create()
    {
        $tag_repository = new TagRepository();
        $tag_name = 'tag';
        $tag_id = $tag_repository->create($tag_name);

        $video_repository = new VideoRepository();
        $video = new stdClass();
        $video->name = 'Yes Sir, I Can Boogie';
        $video->youtube_id = 'VSQjx79dR8s';
        $video->artist_name = 'Boccara';
        $video_id = $video_repository->create($video);

        $video_tag_factory = new VideoTagFactory();

        $data = new stdClass();
        $data->video_id = $video_id;
        $data->name = 'tag';
        $data->start = 0;
        $data->stop = 20;

        $result = $video_tag_factory->create($data);

        $this->assertSame($tag_id, $result->tag_id);

        $this->assertEquals('{"video_id":1,"name":"tag","start":0,"stop":20,"tag_id":1}', json_encode($result));
    }
}
