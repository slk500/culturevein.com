<?php

declare(strict_types=1);

use ApiProblem\ApiProblem;
use Deleter\VideoTagDeleter;
use DTO\RequestTagVideo;
use Factory\TagVideoFactory;
use Database\TagVideoRepository;
use ValueObject\TagVideo;

function tag_video_create(TagVideoFactory $video_tag_factory, RequestTagVideo $video_tag_create): TagVideo
{
    $tag_video = new TagVideo($video_tag_create);
    $video_tag_factory->create($tag_video);
    return $tag_video;
}

function tag_video_list(TagVideoRepository $video_tag_repository)
{
    return $video_tag_repository->find_all_history();
}

function tag_video_list_for_video(TagVideoRepository $video_tag_repository, string $youtube_id)
{
    return tag_video_normalize($video_tag_repository->find_all_for_video($youtube_id));
}

function tag_video_history_for_video(TagVideoRepository $video_tag_repository, string $youtube_id)
{
    return $video_tag_repository->find_all_history_for_video($youtube_id);
}

function tag_video_delete(VideoTagDeleter $video_tag_deleter, string $youtube_id,
                          string $tag_slug_id, ?int $user_id)
{
    if(!$user_id){
        throw new ApiProblem(ApiProblem::USER_NOT_LOGGED_IN);
    }

    $video_tag_deleter->delete($youtube_id, $tag_slug_id, $user_id);
}

function tag_video_completed(TagVideoRepository $video_tag_repository, string $youtube_id, string $tag_slug_id)
{
    $video_tag_repository->set_completed($youtube_id, $tag_slug_id);
}

function tag_video_uncompleted(TagVideoRepository $video_tag_repository, string $youtube_id, string $tag_slug_id)
{
    $video_tag_repository->set_uncompleted($youtube_id, $tag_slug_id);
}
