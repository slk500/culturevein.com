<?php

declare(strict_types=1);

namespace Controller;

use ApiProblem\ApiProblem;
use Deleter\VideoTagTimeDeleter;
use DTO\VideoTagTimeCreate;
use Repository\VideoRepository;
use Repository\VideoTagRepository;
use Repository\VideoTagTimeRepository;

/**
 * @throws ApiProblem
 */
function create(VideoRepository $video_repository, VideoTagRepository $video_tag_repository,
                VideoTagTimeRepository $video_tag_time_repository,
                \stdClass $body, string $youtube_id, string $tag_slug_id, ?int $user_id)
{
    $video = $video_repository->find($youtube_id);

    if (!$video) {
        throw new ApiProblem(ApiProblem::NOT_FOUND);
    }

    $video_tag_id = $video_tag_repository->find($youtube_id, $tag_slug_id);

    $video_tag_create = new VideoTagTimeCreate(
        $video_tag_id,
        $body->start,
        $body->stop,
        $user_id
    );

    $video_tag_time_repository->add($video_tag_create);

    return $body;
}

function delete(VideoTagTimeDeleter $video_tag_timeDeleter, string $youtube_id,
                string $tag_slug_id, int $video_tag_time_id, ?int $user_id)
{
    $video_tag_timeDeleter->delete($video_tag_time_id, $user_id);
}