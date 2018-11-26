<?php

declare(strict_types=1);

namespace Tests\Builder\VideoTag;


use Cocur\Slugify\Slugify;
use Model\VideoTag;

class VideoTagBuilder
{
    private $video_youtube_id = 'HcXNPI-IPPM';
    private $tag_name = "video game";
    private $start = 0;
    private $stop = 20;
    private $is_complete = 1;
    private $video_tag_times = [];

    public function build(): VideoTag
    {
        $video_tag = new VideoTag();
        $video_tag->video_youtube_id = $this->video_youtube_id;
        $video_tag->tag_name = $this->tag_name;
        $video_tag->tag_slug_id = (new Slugify())->slugify($this->tag_name);
        $video_tag->is_complete = $this->is_complete;
        $video_tag->video_tag_times = $this->video_tag_times;

        return $video_tag;
    }

    public function video_tag_times(VideoTagTime $video_tag_time): self
    {
        $this->is_complete = $complete;
        return $this;
    }

    public function is_complete(bool $complete): self
    {
        $this->is_complete = $complete;
        return $this;
    }

    public function video_youtube_id(string $youtube_id): self
    {
        $this->video_youtube_id = $youtube_id;
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