<?php

declare(strict_types=1);

namespace Tests\Factory;

use Factory\VideoTagFactory;
use Factory\VideoFactory;
use DTO\VideoCreate;
use PHPUnit\Framework\TestCase;
use Repository\TagRepository;
use Repository\VideoRepository;
use Service\DatabaseHelper;
use stdClass;

class VideoTagFactoryTest extends TestCase
{
    public static function setUpBeforeClass()
    {
        (new DatabaseHelper())->truncate_all_tables();
    }

    /**
     * @test
     */
    public function create()
    {
        $tag_repository = new TagRepository();
        $tag_name = 'tag';
        $tag_id = $tag_repository->create($tag_name);

        $video_create = new VideoCreate(
            'Burak Yeter',
            'Tuesday ft. Danelle Sandoval',
            'Y1_VsyLAGuk'
        );

        $video_factory = new VideoFactory();
        $video_factory->create($video_create);

        $video_tag_factory = new VideoTagFactory();

        $data = new stdClass();
        $data->video_id = 1;
        $data->name = 'tag';
        $data->start = 0;
        $data->stop = 20;

        $result = $video_tag_factory->create($data);

        $this->assertSame($tag_id, $result->tag_id);

        $this->assertEquals('{"video_id":1,"name":"tag","start":0,"stop":20,"tag_id":1}', json_encode($result));
    }
}
