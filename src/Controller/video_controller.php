<?php

declare(strict_types=1);

use DTO\VideoCreate;
use Factory\VideoFactory;
use Repository\VideoRepository;

function video_create(VideoFactory $video_factory, \stdClass $data, ?int $user_id)
{
    $video_create = new VideoCreate(
        $data->artist,
        $data->name,
        $data->youtube_id,
        $data->duration,
        $user_id
    );

    $video_factory->create($video_create);

    return $video_create;
}

function video_list(VideoRepository $video_repository)
{
    return artist_list_normalize($video_repository->find_all());
}

function video_show(VideoRepository $video_repository, string $youtube_id)
{
    return [$video_repository->find($youtube_id)];
}

function videos_highest_number_of_tags(VideoRepository $video_repository)
{
    return $video_repository->with_highest_number_of_tags();
}

function videos_newest_ten(VideoRepository $video_repository)
{
    return $video_repository->newest_ten();
}