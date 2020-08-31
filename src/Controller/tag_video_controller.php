<?php

declare(strict_types=1);

use Deleter\VideoTagDeleter;
use DTO\RequestTagVideo;
use Factory\TagVideoFactory;
use Repository\VideoTagRepository;
use ValueObject\TagVideo;

//todo should return void - change on frontend
function tag_video_create(TagVideoFactory $video_tag_factory, RequestTagVideo $video_tag_create): RequestTagVideo
{
    $video_tag_factory->create(new TagVideo($video_tag_create));
    return $video_tag_create;
}

function tag_video_list(VideoTagRepository $video_tag_repository)
{
    return $video_tag_repository->find_all();
}

function tag_video_list_for_video(VideoTagRepository $video_tag_repository, string $youtube_id)
{
    return tag_video_normalize($video_tag_repository->find_all_for_video($youtube_id));
}

function tag_video_delete(VideoTagDeleter $video_tag_deleter, string $youtube_id,
                          string $tag_slug_id, ?int $user_id)
{
    $video_tag_deleter->delete($youtube_id, $tag_slug_id, $user_id);
}

function tag_video_completed(VideoTagRepository $video_tag_repository, string $youtube_id, string $tag_slug_id)
{
    $video_tag_repository->set_completed($youtube_id, $tag_slug_id);
}

function tag_video_uncompleted(VideoTagRepository $video_tag_repository, string $youtube_id, string $tag_slug_id)
{
    $video_tag_repository->set_uncompleted($youtube_id, $tag_slug_id);
}
