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
    }

    /**
     * @test
     */
    public function create_and_find()
    {
        $tag_name = 'chess';
        $tag_slug_id = 'chess';

        $this->tag_repository->create($tag_name, $tag_slug_id);

        $tag_slug_id_from_satabase = $this->tag_repository->find_slug_id_by_name($tag_name);

        $this->assertSame($tag_slug_id, $tag_slug_id_from_satabase);
    }
}
