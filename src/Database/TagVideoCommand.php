<?php

declare(strict_types=1);

namespace Database;

use Database\Base\Command;
use ValueObject\TagVideo;

final class TagVideoCommand extends Command
{
    public function add(TagVideo $video_tag_create): ?int
    {
        $stmt = $this->database->mysqli->prepare(
            "INSERT INTO video_tag (video_youtube_id, tag_slug_id, user_id) VALUES (?, ?, ?)"
        );

        if (!$stmt) {
            throw new \Exception($this->database->mysqli->error);
        }

        $stmt->bind_param("ssi",
            $video_tag_create->youtube_id,
            $video_tag_create->tag_slug_id,
            $video_tag_create->user_id
        );

        if (!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }

        file_put_contents(__DIR__ . '/../../cache/cache.txt', null);
        return $stmt->insert_id;
    }

    public function remove(string $video_youtube_id, string $tag_slug_id): void
    {
        $stmt = $this->database->mysqli->prepare(
            "DELETE FROM video_tag WHERE video_youtube_id = ? AND tag_slug_id = ?"
        );

        if (!$stmt) {
            throw new \Exception($this->database->mysqli->error);
        }

        $stmt->bind_param('ss',$video_youtube_id,$tag_slug_id);

        file_put_contents(__DIR__ . '/../../cache/cache.txt', null);
        if (!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }
    }
}

