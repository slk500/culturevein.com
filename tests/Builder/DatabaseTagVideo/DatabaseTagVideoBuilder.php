<?php


namespace Tests\Builder\DatabaseTagVideo;


use DTO\Database\DatabaseTagVideo;

class DatabaseTagVideoBuilder
{
    public $video_slug;

    public $artist_name;

    public $video_name;

    public $tag_duration;

    public $tag_name = 'default_tag_name';

    public $tag_slug = 'default_tag_slug';

    public $video_duration = 0;

    public function build(): DatabaseTagVideo
    {
        $databaseTagVideo = new DatabaseTagVideo();

        $databaseTagVideo->video_slug = $this->video_slug;
        $databaseTagVideo->artist_name = $this->artist_name;
        $databaseTagVideo->video_name = $this->video_name;
        $databaseTagVideo->video_duration = $this->video_duration;
        $databaseTagVideo->tag_slug = $this->tag_slug;
        $databaseTagVideo->tag_name = $this->tag_name;
        $databaseTagVideo->tag_duration = $this->tag_duration;

        return $databaseTagVideo;
    }

    public function video_slug($video_slug): self
    {
        $this->video_slug = $video_slug;
        return $this;
    }

    public function artist_name($artist_name): self
    {
        $this->artist_name = $artist_name;
        return $this;
    }

    public function video_name($video_name): self
    {
        $this->video_name = $video_name;
        return $this;
    }

    public function tag_duration($tag_duration): self
    {
        $this->tag_duration = $tag_duration;
        return $this;
    }

    public function tag_name($tag_name): self
    {
        $this->tag_name = $tag_name;
        return $this;
    }

    public function tag_slug($tag_slug): self
    {
        $this->tag_slug = $tag_slug;
        return $this;
    }

    public function video_duration($video_duration): self
    {
        $this->video_duration = $video_duration;
        return $this;
    }
}