<?php

declare(strict_types=1);

namespace Tests\Builder;


use Cocur\Slugify\Slugify;
use Model\VideoTag;

class VideoTagBuilder
{
    private $video_tag_id = 10;
    private $video_youtube_id = 'HcXNPI-IPPM';
    private $tag_name = "BMW";
    private $start = 0;
    private $stop = 20;
    private $complete = 1;

    public function build(): VideoTag
    {
        $video_tag = new VideoTag();
        $video_tag->video_tag_id = $this->video_tag_id;
        $video_tag->video_youtube_id = $this->video_youtube_id;
        $video_tag->tag_name = $this->tag_name;
        $video_tag->start = $this->start;
        $video_tag->stop = $this->stop;
        $video_tag->tag_slug_id = (new Slugify())->slugify($this->tag_name);
        $video_tag->complete = $this->complete;

        return $video_tag;
    }

    public function complete(bool $complete): self
    {
        $this->complete = $complete;
        return $this;
    }

    public function video_tag_id(int $video_tag_id): self
    {
        $this->video_tag_id = $video_tag_id;
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