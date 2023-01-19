<?php

declare(strict_types=1);

use Model\Tag;
use PHPUnit\Framework\TestCase;
use Database\Base\Database;
use Database\TagRepository;
use Tests\DatabaseHelper;

class TagRepositoryTest extends TestCase
{
    /**
     * @var TagRepository
     */
    private $tag_repository;

    public function setUp()
    {
        $container = new Container();
        (new DatabaseHelper($container->get(Database::class)))
            ->truncate_all_tables();

        $this->tag_repository = $container->get(TagRepository::class);
    }

    /**
     * @test
     */
    public function create_and_find()
    {
        $tag = new Tag('tag name');

        $this->tag_repository->add($tag);

        $tag_from_database = $this->tag_repository->find($tag->slug_id);

        $this->assertSame($tag->slug_id, $tag_from_database->slug_id);
    }
}
