<?php

declare(strict_types=1);

namespace Tests\Builder;

use DTO\VideoTagCreate;
use Factory\VideoTagFactory;

class VideoTagBuilder
{

    private $youtube_id;
    private $tag_name;
    private $start;
    private $stop;

    public function build(): void
    {
        $video_create = new VideoTagCreate(
            $this->youtube_id,
            $this->tag_name,
            $this->start,
            $this->stop
        );

        (new VideoTagFactory())->create($video_create);
    }

    public function youtube_id(string $youtube_id): self
    {
        $this->youtube_id = $youtube_id;
        return $this;
    }

    public function tag_name(string $tag_name): self
    {
        $this->tag_name = $tag_name;
        return $this;
    }

    public function start(int $start): self
    {
        $this->start = $start;
        return $this;
    }

    public function stop(int $stop): self
    {
        $this->stop = $stop;
        return $this;
    }


}