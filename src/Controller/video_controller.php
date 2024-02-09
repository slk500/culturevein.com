<?php

declare(strict_types=1);

use DTO\RequestVideoCreate;
use Factory\VideoFactory;
use Database\VideoRepository;

function video_create(VideoFactory $video_factory, RequestVideoCreate $video_create): void
{
    file_put_contents(__DIR__ . '/../../cache/video_list.php', null);
    $video_factory->create($video_create);
}

function video_list(VideoRepository $video_repository)
{
    clearstatcache();
    if (filesize(__DIR__ . '/../../cache/video_list.php') == 0) {
        cache_set(__DIR__ . '/../../cache/video_list.php',
            artist_list_normalize($video_repository->find_all())
        );
    }

    return cache_get(__DIR__ . '/../../cache/video_list.php');
}

function video_list_new(VideoRepository $video_repository)
{
    return $video_repository->newest_ten();
}

function video_list_count_tags(VideoRepository $video_repository)
{
    return $video_repository->with_highest_number_of_tags();
}

function video_show(VideoRepository $video_repository, string $youtube_id)
{
    return [$video_repository->find($youtube_id)];
}
