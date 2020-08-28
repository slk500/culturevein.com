<?php

declare(strict_types=1);

namespace DTO;


class TagVideoTimeCreate implements RequestData
{
    public int $start;

    public int $stop;

    public string $youtube_id;
    
    public string $tag_slug_id;
    
    public ?int $user_id;
}