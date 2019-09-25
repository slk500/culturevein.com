<?php

declare(strict_types=1);

namespace DTO;

class VideoCreate
{
    public $artist_name;

    public $video_name;

    public $youtube_id;

    public $user_id = null;

    public $duration = 0;

    public function __construct(string $artist_name, string $video_name, string $youtube_id, int $duration, ?int $user_id = null)
    {
        $this->artist_name = $artist_name;
        $this->video_name = $video_name;
        $this->youtube_id = $youtube_id;
        $this->user_id = $user_id;
        $this->duration = $duration;
    }
}