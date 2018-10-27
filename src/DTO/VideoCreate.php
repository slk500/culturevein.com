<?php

declare(strict_types=1);

namespace DTO;

class VideoCreate
{
    public $artist_name;

    public $video_name;

    public $youtube_id;

    public function __construct(string $artist_name, string $video_name, string $youtube_id)
    {
        $this->artist_name = $artist_name;
        $this->video_name = $video_name;
        $this->youtube_id = $youtube_id;
    }
}