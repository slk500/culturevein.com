<?php

declare(strict_types=1);

namespace Tests\Builder;

use DTO\VideoTagCreate;
use Factory\VideoTagFactory;

class VideoTagCreateBuilder
{

    private $youtube_id = 'Y1_VsyLAGuk';
    private $tag_name = 'tag name';
    private $start = 0;
    private $stop = 20;

    public function build(): VideoTagCreate
    {
        return new VideoTagCreate(
            $this->youtube_id,
            $this->tag_name,
            $this->start,
            $this->stop
        );
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

