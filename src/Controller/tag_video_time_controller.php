<?php

declare(strict_types=1);

use Deleter\VideoTagTimeDeleter;
use DTO\TagVideoTimeCreate;
use Repository\VideoTagRepository;
use Repository\VideoTagTimeRepository;

function tag_video_time_create(VideoTagRepository $video_tag_repository,
                               VideoTagTimeRepository $video_tag_time_repository,
                               TagVideoTimeCreate $tag_video_time_create): void
{
    //shitfix
    $tag_video_time_create->video_tag_id = $video_tag_repository->find(
        $tag_video_time_create->youtube_id, $tag_video_time_create->tag_slug_id);

    $video_tag_time_repository->add($tag_video_time_create);
}

function tag_video_time_delete(VideoTagTimeDeleter $video_tag_time_deleter, int $video_tag_time_id, ?int $user_id): void
{
    $video_tag_time_deleter->delete($video_tag_time_id, $user_id);
}