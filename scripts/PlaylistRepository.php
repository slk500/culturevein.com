<?php

use Database\Base\Repository;

require_once '../vendor/autoload.php';

class PlaylistRepository extends Repository
{
    public function find_not_created(): array
    {
        return $this->database->fetch("
SELECT tag.tag_slug_id, name
FROM tag
LEFT JOIN yt_playlist ON tag.tag_slug_id = yt_playlist.tag_slug_id
WHERE yt_playlist_id is NULL
");
    }

    public function create_playlist(string $yt_playlist_id, string $tag_slug_id): void
    {
        $stmt = $this->database->mysqli->prepare("INSERT INTO yt_playlist (yt_playlist_id, tag_slug_id) VALUES (?, ?)");
        $stmt->bind_param("ss", $yt_playlist_id, $tag_slug_id);
        $stmt->execute();
    }

    public function add_video_to_playlist(string $yt_playlist_id, string $tag_slug_id): void
    {
        $stmt = $this->database->mysqli->prepare("INSERT INTO yt_playlist_video (yt_playlist_id, video_youtube_id) VALUES (?, ?)");
        $stmt->bind_param("ss", $yt_playlist_id, $tag_slug_id);
        $stmt->execute();
    }
}