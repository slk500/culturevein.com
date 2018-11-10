<?php

declare(strict_types=1);

namespace Deleter;


use Repository\VideoTagRepository;

class VideoTagDeleter
{
    private $video_tag_repository;

    public function __construct()
    {
        $this->video_tag_repository = new VideoTagRepository();
    }

    public function delete(int $video_tag_id)
    {
        $this->video_tag_repository->set_start_and_stop_null($video_tag_id);
    }
}

