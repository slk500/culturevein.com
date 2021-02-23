<?php

declare(strict_types=1);

use ApiProblem\ApiProblem;
use Database\SubscribeRepository;
use Database\TagRepository;

function tag_list(TagRepository $tag_repository)
{
    clearstatcache();
    if (filesize(__DIR__ . '/../../cache/cache.txt') == 0) {
        cache_set(__DIR__ . '/../../cache/cache.txt',
            set_relations($tag_repository->find_all_with_number_of_videos())
        );
    }

    return cache_get(__DIR__ . '/../../cache/cache.txt');
}

function tag_list_without_relation(TagRepository $tag_repository): array
{
    return $tag_repository->find_all(); //use in select2
}

/**
 * @throws ApiProblem
 */
function tag_show(TagRepository $tag_repository, SubscribeRepository $subscribe_repository, string $tag_slug_id): array
{
    $tag = $tag_repository->find($tag_slug_id);

    if (!$tag) {
        throw new ApiProblem(ApiProblem::NOT_FOUND);
    }

    $tag_videos = $tag_repository->find_videos($tag->slug_id);

    $result = tag_show_normalizer($tag_videos, $tag);

    return [
        'name' => $tag->name,
        'subscribers' => $subscribe_repository->get_subscribers_number($tag->slug_id),
        'videos' => $result
    ];
}

function tag_new(TagRepository $tag_repository): array
{
    return $tag_repository->newest_ten();
}

function tag_descendants(TagRepository $tag_repository, string $tag_slug_id)
{
    return $tag_repository->find_descendants($tag_slug_id);
}

function tag_ancestors(TagRepository $tag_repository, string $tag_slug_id)
{
    return $tag_repository->find_ancestors($tag_slug_id);
}

