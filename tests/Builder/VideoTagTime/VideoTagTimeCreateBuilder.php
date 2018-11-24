<?php

declare(strict_types=1);

namespace Tests\Builder\VideoTagTime;

use Cocur\Slugify\Slugify;
use DTO\VideoTagTimeCreate;

class VideoTagTimeCreateBuilder
{
    public $video_tag_id = 1;

    public $start = 0;

    public $stop = 10;

    public $user_id;

    public function build(): VideoTagTimeCreate
    {
        return new VideoTagTimeCreate(
            $this->video_tag_id,
            $this->start,
            $this->stop,
            $this->user_id
        );
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