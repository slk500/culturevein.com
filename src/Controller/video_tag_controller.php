<?php

declare(strict_types=1);

namespace Controller;

use Deleter\VideoTagDeleter;
use DTO\VideoTagCreate;
use Factory\VideoTagFactory;
use Repository\VideoTagRepository;

//todo what if tag dosent exist?
function video_tag_create(VideoTagFactory $video_tag_factory, \stdClass $data, string $youtube_id, ?int $user_id)
{
    $video_tag_create = new VideoTagCreate(
        $youtube_id,
        $data->tag_name,
        $user_id
    );

    $video_tag_factory->create($video_tag_create);
    return $video_tag_create;
}

function video_tag_list(VideoTagRepository $video_tag_repository)
{
    return $video_tag_repository->find_all();
}

function list_for_video(VideoTagRepository $video_tag_repository, string $youtube_id)
{
    return video_tag_normalize($video_tag_repository->find_all_for_video($youtube_id));
}

function video_tag_delete(VideoTagDeleter $video_tag_deleter, string $video_youtube_id,
                          string $tag_slug_id, ?int $user_id)
{
    $video_tag_deleter->delete($video_youtube_id, $tag_slug_id, $user_id);
}

function video_tag_update(VideoTagRepository $video_tag_repository, \stdClass $data, string $video_youtube_id, string $tag_slug_id)
{
    $video_tag_repository->set_is_complete($video_youtube_id, $tag_slug_id, $data->is_complete);
}
