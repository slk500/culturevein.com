<?php

declare(strict_types=1);

namespace Tests\Builder;


use DTO\VideoCreate;
use Factory\VideoFactory;

class VideoBuilder
{
    private $artist_name;
    private $video_name;
    private $youtube_id;

    public function build(): void
    {
        $video_create = new VideoCreate(
            $this->artist_name,
            $this->video_name,
            $this->youtube_id
        );

        (new VideoFactory())->create($video_create);
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
}

