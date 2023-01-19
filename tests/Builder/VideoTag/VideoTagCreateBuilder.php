<?php

declare(strict_types=1);

namespace Tests\Builder\VideoTag;

use DTO\RequestTagVideo;

class VideoTagCreateBuilder
{
    private $youtube_id = 'Y1_VsyLAGuk';
    private $tag_name = 'video game';

    public function build(): RequestTagVideo
    {
        return new RequestTagVideo(
            $this->youtube_id,
            $this->tag_name
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
}

