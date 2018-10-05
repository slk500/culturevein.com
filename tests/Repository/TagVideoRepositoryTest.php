<?php

use PHPUnit\Framework\TestCase;
use Repository\TagVideoRepository;

class TagVideoRepositoryTest extends TestCase
{
    /**
     * @var TagVideoRepository
     */
    private $tagVideoRepository;

    public function setUp()
    {
        $this->tagVideoRepository = new TagVideoRepository();
    }

    /**
     * @test
     */
    public function create_tag()
    {
        $data = new stdClass();
        $data->name = 'newTag';

        $tagId = $this->tagVideoRepository->create($data);

        $this->assertNotNull($tagId);
    }
}
