<?php

declare(strict_types=1);

namespace Database;

use DTO\RequestVideoCreate;
use Model\Video;
use Database\Base\Repository;

final class VideoRepository extends Repository
{
    public function add(RequestVideoCreate $video_create): void
    {
        $stmt = $this->database->mysqli->prepare("INSERT INTO video (video_youtube_id, name, duration, user_id) VALUES (?,?,?,?)");
        if (!$stmt) {
            throw new \Exception($this->database->mysqli->error);
        }

        $stmt->bind_param("ssii",
            $video_create->youtube_id, $video_create->video_name, $video_create->duration, $video_create->user_id);
        if (!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }
    }

    public function find(string $video_youtube_id): ?Video
    {
        $stmt = $this->database->mysqli->prepare("
            SELECT 
            video.name as video_name, 
            video.release_date, 
            video.video_youtube_id, 
            video.duration,
            video.user_id,
           -- video.country, 
           -- video.genre,
            artist.name as artist_name,            
            artist.artist_slug_id as artist_slug
            FROM video
            LEFT JOIN artist_video USING (video_youtube_id)
            LEFT JOIN artist USING (artist_slug_id)
            WHERE video.video_youtube_id = ?");

        $stmt->bind_param("s", $video_youtube_id);
        $stmt->execute();

        $result = $stmt->get_result();
        return mysqli_fetch_object($result, Video::class);
    }

    public function find_all(): ?array
    {
        return $this->database->fetch("SELECT video_youtube_id, 
                artist.name AS artist_name,
                artist.artist_slug_id AS artist_slug,
                video.name AS video_name
                FROM video
                LEFT JOIN artist_video USING (video_youtube_id)
                LEFT JOIN artist USING (artist_slug_id)
                ORDER BY artist.name, video.name -- limit 2");
    }

    public function with_highest_number_of_tags()
    {
        return $this->database->fetch("SELECT 
               artist.name AS artist_name, 
               video.name AS video_name,  
               count(tag.tag_slug_id) AS count,
              video.video_youtube_id
              FROM video_tag
              JOIN tag USING (tag_slug_id)
              JOIN video USING (video_youtube_id)
              LEFT JOIN artist_video USING (video_youtube_id)
              LEFT JOIN artist USING (artist_slug_id)
              GROUP BY video.video_youtube_id, artist.name
              ORDER BY count DESC
              LIMIT 10
              ");
    }

    public function newest_ten()
    {
        return $this->database->fetch("SELECT 
                video.video_youtube_id,
                artist.name AS artist_name, 
                video.name AS video_name
                FROM video
                LEFT JOIN artist_video USING (video_youtube_id)
                LEFT JOIN artist USING (artist_slug_id)
                ORDER BY video.created_at DESC
                LIMIT 10");
    }
}
