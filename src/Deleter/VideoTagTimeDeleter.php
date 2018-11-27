<?php

declare(strict_types=1);

namespace Deleter;


use Model\VideoTag;
use Repository\VideoTagRepository;
use Repository\VideoTagTimeRepository;

final class VideoTagTimeDeleter
{
    private $video_tag_time_repository;

    public function __construct()
    {
        $this->video_tag_time_repository = new VideoTagTimeRepository();
    }

    public function delete(int $video_tag_time_id, ?int $user_id)
    {
        $this->video_tag_time_repository->delete($video_tag_time_id);
    }
}

