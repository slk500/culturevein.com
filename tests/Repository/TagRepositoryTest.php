<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Repository\TagRepository;
use Service\DatabaseHelper;

class TagRepositoryTest extends TestCase
{
    /**
     * @var TagRepository
     */
    private $tag_repository;

    public static function setUpBeforeClass()
    {
        (new DatabaseHelper())->truncate_all_tables();
    }

    public function setUp()
    {
        $this->tag_repository = new TagRepository();
        (new DatabaseHelper())->truncate_tables([
            'tag'
        ]);
    }

    /**
     * @test
     */
    public function create_tag()
    {
        $tag_name = 'chess';

        $tag_id = $this->tag_repository->create($tag_name);

        $this->assertSame(1, $tag_id);
    }

    /**
     * @test
     */
    public function find_id_by_name()
    {
        $tag_name = 'tag';

        $tag_id = $this->tag_repository->create($tag_name);

        $found_id = $this->tag_repository->find_id_by_name($tag_name);

        $this->assertSame($tag_id, $found_id);
    }


}
