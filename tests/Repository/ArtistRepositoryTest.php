<?php

declare(strict_types=1);

namespace Tests\Repository;

use PHPUnit\Framework\TestCase;
use Repository\ArtistRepository;
use Service\DatabaseHelper;

class ArtistRepositoryTest extends TestCase
{
    /**
     * @var ArtistRepository
     */
    private $artist_repository;

    public static function setUpBeforeClass()
    {
        (new DatabaseHelper())->truncate_all_tables();
    }

    public function setUp()
    {
        $this->artist_repository = new ArtistRepository();
    }

    /**
     * @test
     */
    public function create_and_find()
    {
        $this->artist_repository->create('Kazik Staszewski', 'kazik-staszewski');

        $artist_slug_id = $this->artist_repository->find_slug_id_by_name('Kazik Staszewski');

        $this->assertSame('kazik-staszewski', $artist_slug_id);
    }
}
