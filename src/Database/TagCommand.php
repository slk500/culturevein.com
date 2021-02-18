<?php

declare(strict_types=1);

namespace Database;

use Database\Base\Command;
use Model\Tag;

final class TagCommand extends Command
{
    public function add(Tag $tag): void
    {
        $stmt = $this->database->mysqli->prepare("INSERT INTO tag (name, tag_slug_id) VALUES (?, ?)");
        $stmt->bind_param("ss", $tag->name, $tag->slug_id);
        $stmt->execute();
    }
}

