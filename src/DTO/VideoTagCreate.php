<?php

declare(strict_types=1);

namespace DTO;


use Cocur\Slugify\Slugify;

class VideoTagCreate
{
    public $video_youtube_id;

    public $tag_name;

    public $tag_slug_id;

    public $start;

    public $stop;

    public function __construct(string $video_youtube_id, string $tag_name, ?int $start, ?int $stop)
    {
        $this->video_youtube_id = $video_youtube_id;
        $this->tag_name = $tag_name;
        $this->tag_slug_id = (new Slugify())->slugify($tag_name);
        $this->start = $start;
        $this->stop = $stop;
    }
}