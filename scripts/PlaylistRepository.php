<?php

use Repository\Base\Repository;

require_once '../vendor/autoload.php';

class PlaylistRepository extends Repository
{
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