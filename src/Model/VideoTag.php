<?php

declare(strict_types=1);


namespace Model;

//todo time_range -> start, stop
class VideoTag
{
    public $video_tag_id;

    public $video_youtube_id;

    public $tag_name;

    public $start;

    public $stop;

    public $tag_slug_id;

    public $complete;

    public $user_id;
}