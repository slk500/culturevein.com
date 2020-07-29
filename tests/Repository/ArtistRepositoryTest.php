<?php

declare(strict_types=1);

namespace Tests\Repository;

use Container;
use PHPUnit\Framework\TestCase;
use Repository\ArtistRepository;
use Repository\Base\Database;
use Tests\DatabaseHelper;

class ArtistRepositoryTest extends TestCase
{
    /**
     * @var ArtistRepository
     */
    private $artist_repository;

    public function setUp()
    {
        $container = new Container();
        (new DatabaseHelper($container->get(Database::class)))
            ->truncate_all_tables();

        $this->artist_repository = $container->get(ArtistRepository::class);
    }

    /**
     * @test
     */
    public function create_and_find()
    {
        $this->artist_repository->add('Kazik Staszewski', 'kazik-staszewski');

        $artist_slug_id = $this->artist_repository->find_slug_id_by_name('Kazik Staszewski');

        $this->assertSame('kazik-staszewski', $artist_slug_id);
    }
}
