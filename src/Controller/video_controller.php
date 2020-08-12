<?php

declare(strict_types=1);

use DTO\VideoCreate;
use Factory\VideoFactory;
use Repository\VideoRepository;

function video_create(VideoFactory $video_factory, VideoCreate $video_create)
{
    $video_factory->create($video_create);
    return $video_create;
}

function video_list(VideoRepository $video_repository)
{
    return artist_list_normalize($video_repository->find_all());
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


