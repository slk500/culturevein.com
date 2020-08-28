<?php

declare(strict_types=1);

namespace DTO;

class RequestTagVideo implements RequestData
{
    public string $youtube_id;

    public string $tag_name;

    public ?int $user_id;
}