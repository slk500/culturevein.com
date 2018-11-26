<?php

declare(strict_types=1);

namespace Deleter;


use Model\VideoTag;
use Repository\VideoTagRepository;

final class VideoTagDeleter
{
    private $video_tag_repository;

    public function __construct()
    {
        $this->video_tag_repository = new VideoTagRepository();
    }

    public function delete(string $video_youtube_id, string $tag_slug_id, ?int $user_id)
    {
        $this->video_tag_repository->delete($video_youtube_id, $tag_slug_id);
    }
}

