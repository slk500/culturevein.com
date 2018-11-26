<?php

declare(strict_types=1);

namespace Tests\Builder\VideoTag;


use Cocur\Slugify\Slugify;
use DTO\VideoTagRaw;
use Model\VideoTag;

class VideoTagRawBuilder
{
    private $video_tag_id = 1;

    private $video_tag_time_id = 1;

    private $video_youtube_id = 'HcXNPI-IPPM';

    private $tag_name = "video game";

    private $tag_slug_id;

    private $start = 0;

    private $stop = 10;

    private $is_complete = true;

    private $user_id = 1;


    public function build(): VideoTagRaw
    {
        $video_tag_raw = new VideoTagRaw();
        $video_tag_raw->video_tag_id = $this->video_tag_id;
        $video_tag_raw->video_tag_time_id = $this->video_tag_time_id;
        $video_tag_raw->video_youtube_id = $this->video_youtube_id;
        $video_tag_raw->tag_name = $this->tag_name;
        $video_tag_raw->tag_slug_id = (new Slugify())->slugify($this->tag_name);
        $video_tag_raw->start = $this->start;
        $video_tag_raw->stop = $this->stop;
        $video_tag_raw->is_complete = $this->is_complete;
        $video_tag_raw->user_id = $this->user_id;

        return $video_tag_raw;
    }

    public function video_tag_time_id (int $video_tag_time_id): self
    {
        $this->video_tag_time_id = $video_tag_time_id;
        return $this;
    }

    public function video_tag_id (int $video_tag_id): self
    {
        $this->video_tag_id = $video_tag_id;
        return $this;
    }

    public function video_youtube_id(string $youtube_id): self
    {
        $this->video_youtube_id = $youtube_id;
        return $this;
    }

    public function is_complete(bool $is_complete): self
    {
        $this->is_complete = $is_complete;
        return $this;
    }

    public function tag_name(string $tag_name): self
    {
        $this->tag_name = $tag_name;
        return $this;
    }

    public function start(?int $start): self
    {
        $this->start = $start;
        return $this;
    }

    public function stop(?int $stop): self
    {
        $this->stop = $stop;
        return $this;
    }
}