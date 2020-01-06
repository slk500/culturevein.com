<?php

declare(strict_types=1);

namespace Model;

use Cocur\Slugify\Slugify;

class Tag
{
    public string $name;

    public string $slug_id;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->slug_id = (new Slugify())->slugify($name);
    }
}

