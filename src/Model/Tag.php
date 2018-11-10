<?php

declare(strict_types=1);

namespace Model;


use Cocur\Slugify\Slugify;

class Tag
{
    public $tag_name;

    public $tag_slug_id;

    public function __construct(string $tag_name)
    {
        $this->tag_name = $tag_name;
        $this->tag_slug_id = (new Slugify())->slugify($tag_name);
    }
}

