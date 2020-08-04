<?php

declare(strict_types=1);

use ApiProblem\ApiProblem;
use Repository\SubscribeRepository;
use Repository\TagRepository;

function tag_list(TagRepository $tag_repository)
{
    return normalize_tag_list_with_children($tag_repository->find_all());
}

//use in select2
function list_without_relation(TagRepository $tag_repository)
{
    return $tag_repository->find_all();
}

/**
 * @throws ApiProblem
 */
function show(TagRepository $tag_repository, SubscribeRepository $subscribe_repository, string $slug): array
{
    $tag = $tag_repository->find($slug);

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

function top_ten(TagRepository $tag_repository)
{
    return $tag_repository->count_tag_in_videos();
}

function newest_ten(TagRepository $tag_repository)
{
    return $tag_repository->newest_ten();
}
