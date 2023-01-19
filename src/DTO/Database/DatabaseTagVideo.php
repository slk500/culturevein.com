<?php

declare(strict_types=1);

namespace DTO\Database;

class DatabaseTagVideo
{
    public ?string $video_slug;

    public ?string $artist_name;

    public ?string $video_name;

    public ?int $tag_duration;

    public string $tag_name;

    public string $tag_slug;

    public int $video_duration;
}

