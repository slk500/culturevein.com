<?php

declare(strict_types=1);

namespace Tests\Repository;

use PHPUnit\Framework\TestCase;
use Repository\ArtistRepository;

class ArtistRepositoryTest extends TestCase
{
    /**
     * @test
     */
    public function find()
    {
        $artistRepository = new ArtistRepository();
        $result = $artistRepository->find('Burak Yeter');

        var_dump($result);
    }
}
