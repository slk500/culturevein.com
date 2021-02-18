<?php

declare(strict_types=1);

use Database\ArtistRepository;

function artist_list(ArtistRepository $artist_repository)
{
    return $artist_repository->find_all(); //used in select2
}

function artist_show(ArtistRepository $artist_repository, string $artist_slug_id)
{
    return artist_show_normalize($artist_repository->find($artist_slug_id));
}