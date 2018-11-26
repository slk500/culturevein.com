<?php

declare(strict_types=1);

use Model\Tag;
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
        $tag = new Tag('tag name');

        $this->tag_repository->save($tag);

        $tag_slug_id_from_database = $this->tag_repository->find_slug_id_by_name($tag->tag_name);

        $this->assertSame($tag->tag_slug_id, $tag_slug_id_from_database);
    }
}
