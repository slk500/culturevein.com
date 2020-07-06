<?php

declare(strict_types=1);

namespace Controller;

use Container;
use Repository\ArtistRepository;
use function Normalizer\artist_show_normalize;

final class ArtistController
{
    private ArtistRepository $artist_repository;

    public function __construct()
    {
        $this->artist_repository = (new Container())->get(ArtistRepository::class);
    }

    public function show(string $artist_slug_id)
    {
        return artist_show_normalize($this->artist_repository->find($artist_slug_id));
    }

    public function list()
    {
        return $this->artist_repository->find_all();
    }
}