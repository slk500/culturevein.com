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

    public function create()
    {
        $artist_id = $this->artist_repository->create('Kazik Staszewski');
        $this->assertSame(1, $artist_id);
    }

    /**
     * @test
     */
    public function find_id_by_name()
    {
        $artist_id = $this->artist_repository->create('Kazik Staszewski');

        $artistRepository = new ArtistRepository();
        $found_id = $artistRepository->find('Kazik Staszewski');

        $this->assertSame($artist_id, $found_id);
    }
}
