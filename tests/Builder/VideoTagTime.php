<?php

declare(strict_types=1);


namespace Tests\Builder;


class VideoTagTime
{
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