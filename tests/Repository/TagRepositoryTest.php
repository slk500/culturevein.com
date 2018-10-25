<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Repository\TagRepository;

class TagRepositoryTest extends TestCase
{
    /**
     * @var TagRepository
     */
    private $tagRepository;

    public function setUp()
    {
        $this->tagRepository = new TagRepository();
    }

    /**
     * @test
     */
    public function create_tag()
    {
        $data = new stdClass();
        $data->video_id = 3799;
        $data->name = 'chess';
        $data->start = 0;
        $data->stop = 25;

        $tagId = $this->tagRepository->create($data);

        $this->assertNotNull($tagId);
    }
}
