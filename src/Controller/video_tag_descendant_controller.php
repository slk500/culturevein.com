<?php

declare(strict_types=1);

namespace Controller;

use Repository\TagRepository;

function descendants(TagRepository $tag_repository, string $slug)
{
    return $tag_repository->find_descendants_simple($slug);
}

function ancestors(TagRepository $tag_repository, string $slug)
{
    return $tag_repository->find_ancestors($slug);
}