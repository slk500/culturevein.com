<?php

declare(strict_types=1);

namespace Repository;

use Cocur\Slugify\Slugify;
use Repository\Base\Database;

final class ArtistRepository
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function save(string $artist_name, string $artist_slug_id)
    {
        $stmt = $this->database->mysqli->prepare("INSERT INTO artist (name, artist_slug_id) VALUES (?,?)");
        $stmt->bind_param("ss", $artist_name, $artist_slug_id);
        $stmt->execute();
    }

    public function find_slug_id_by_name(string $artist_name)
    {
        $stmt = $this->database->mysqli->prepare("SELECT artist_slug_id FROM artist WHERE name = ?");
        $stmt->bind_param("s", $artist_name);
        $stmt->execute();
        $stmt->bind_result($artist_slug_id);
        $stmt->fetch();

        return $artist_slug_id;
    }

    public function find(string $artist_slug_id): array
    {
        $stmt = $this->database->mysqli->prepare("
                    SELECT
            video.name as video_name,
            video.release_date,
            video.video_youtube_id,
            video.duration,
            artist.name as artist_name,
            t.name AS tag_name,
            t.tag_slug_id AS tag_slug
        FROM video
                 LEFT JOIN artist_video USING (video_youtube_id)
                 LEFT JOIN artist USING (artist_slug_id)
                 LEFT JOIN video_tag vt on video.video_youtube_id = vt.video_youtube_id
                 LEFT JOIN tag t on vt.tag_slug_id = t.tag_slug_id
        WHERE artist_slug_id = ?");

        $stmt->bind_param("s", $artist_slug_id);
        $stmt->execute();

        $result = $stmt->get_result();
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function assign_video_to_artist(string $artist_slug_id, string $video_id)
    {
        $stmt = $this->database->mysqli->prepare("INSERT INTO artist_video (artist_slug_id, video_youtube_id) VALUES (?,?)");
        $stmt->bind_param("ss", $artist_slug_id, $video_id);
        $stmt->execute();
    }
}