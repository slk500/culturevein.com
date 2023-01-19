<?php

declare(strict_types=1);

namespace Tests\Builder\Video;


use DTO\RequestVideoCreate;

class VideoCreateBuilder
{
    private $artist_name = 'Burak Yeter';

    private $video_name = 'Tuesday ft. Danelle Sandoval';

    private $youtube_id = 'Y1_VsyLAGuk';

    private $user_id = null;

    private $duration = 10;

    public function build(): RequestVideoCreate
    {
        return new RequestVideoCreate(
            $this->artist_name,
            $this->video_name,
            $this->youtube_id,
            $this->duration,
            $this->user_id
        );
    }

    public function artist_name(string $artist_name): self
    {
        $this->artist_name = $artist_name;
        return $this;
    }

    public function video_name(string $video_name): self
    {
        $this->video_name = $video_name;
        return $this;
    }

    public function youtube_id(string $youtube_id): self
    {
        $this->youtube_id = $youtube_id;
        return $this;
    }

    public function user_id(int $user_id): self
    {
        $this->user_id = $user_id;
        return $this;
    }
}

