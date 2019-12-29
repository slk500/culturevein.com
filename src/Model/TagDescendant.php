<?php

declare(strict_types=1);

namespace Model;

class TagDescendant
{
    public $tag_descendant;

    public $tag_ancestor;

    public function __construct(string $tag_descendant, string $tag_ancestor)
    {
        $this->tag_descendant = $tag_descendant;
        $this->tag_ancestor = $tag_ancestor;
    }
}

