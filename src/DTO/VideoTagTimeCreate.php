<?php

declare(strict_types=1);

namespace DTO;


class VideoTagTimeCreate
{
    public $video_tag_id;

    public $start;

    public $stop;

    public $user_id;

    public function __construct(int $video_tag_id, int $start, int $stop, ?int $user_id = null)
    {
        $this->video_tag_id = $video_tag_id;
        $this->start = $start;
        $this->stop = $stop;
        $this->user_id = $user_id;
    }
}