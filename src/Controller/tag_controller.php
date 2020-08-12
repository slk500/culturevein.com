<?php

declare(strict_types=1);

use ApiProblem\ApiProblem;
use Repository\SubscribeRepository;
use Repository\TagRepository;

function tag_list(TagRepository $tag_repository): array
{
    return normalize_tag_list_with_relation($tag_repository->find_all());
}

//use in select2
function tag_list_without_relation(TagRepository $tag_repository): array
{
    return $tag_repository->find_all();
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

function tag_in_videos(TagRepository $tag_repository): array
{
    return $tag_repository->count_tag_in_videos();
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