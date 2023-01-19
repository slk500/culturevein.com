<?php

declare(strict_types=1);


namespace Tests\Builder\VideoTagTime;


use DTO\RequestTagVideoTimeCreate;

class VideoTagTimeBuilder
{
    public $video_tag_id;

    public $start;

    public $stop;

    public $user_id;

    public function build(): RequestTagVideoTimeCreate
    {
        return new VideoTagCreate(
            $this->youtube_id,
            $this->tag_name
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