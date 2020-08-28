<?php

declare(strict_types=1);

namespace DTO;

class RequestVideoCreate implements RequestData
{
    public string $artist_name;

    public string $video_name;

    public string $youtube_id;

    public int $duration;

    public ?int $user_id;
}