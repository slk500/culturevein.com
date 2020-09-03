<?php

declare(strict_types=1);

use Deleter\VideoTagTimeDeleter;
use DTO\RequestTagVideoTimeCreate;
use Repository\TagVideoRepository;
use Repository\TagVideoTimeRepository;

//todo should return void - change on frontend
function tag_video_time_create(TagVideoRepository $video_tag_repository,
                               TagVideoTimeRepository $video_tag_time_repository,
                               RequestTagVideoTimeCreate $tag_video_time_create)
{
    //todo should be new object
    $tag_video_time_create->video_tag_id = $video_tag_repository->find(
        $tag_video_time_create->youtube_id, $tag_video_time_create->tag_slug_id);

    $video_tag_time_repository->add($tag_video_time_create);

    return $tag_video_time_create;
}

function tag_video_time_delete(VideoTagTimeDeleter $video_tag_time_deleter, int $video_tag_time_id, ?int $user_id): void
{
    $video_tag_time_deleter->delete($video_tag_time_id, $user_id);
}