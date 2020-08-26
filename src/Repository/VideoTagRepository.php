<?php

declare(strict_types=1);

namespace Repository;

use DTO\VideoTagCreate;
use Repository\Base\Repository;

final class VideoTagRepository extends Repository
{
    public function add(VideoTagCreate $video_tag_create): ?int
    {
        $stmt = $this->database->mysqli->prepare(
            "INSERT INTO video_tag (video_youtube_id, tag_slug_id, user_id) VALUES (?, ?, ?)"
        );

        if (!$stmt) {
            throw new \Exception($this->database->mysqli->error);
        }

        $stmt->bind_param("ssi",
            $video_tag_create->video_youtube_id,
             $video_tag_create->tag_slug_id,
                    $video_tag_create->user_id
        );

        if (!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }

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

        if (!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }
    }

    public function find_all_for_video(string $youtubeId): array
    {
        $stmt = $this->database->mysqli->prepare("
    SELECT
        vt.video_tag_id,
        vt.video_youtube_id,
        vt.tag_slug_id,
        vt.user_id,
        vt.is_complete,
        vtt.video_tag_time_id,
        tag.name as tag_name,
        start,
        stop
    FROM video_tag vt
        LEFT JOIN video_tag_time vtt using (video_tag_id)
        LEFT JOIN tag USING (tag_slug_id)
        LEFT JOIN video USING (video_youtube_id)
        WHERE video.video_youtube_id = ?
        ORDER BY tag.name, start
        ");

        $stmt->bind_param("s", $youtubeId);
        $stmt->execute();

        $result = $stmt->get_result();
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function find_all(): array
    {
        return $this->database->fetch("SELECT
              vt.video_youtube_id,
              v.name   AS video_name,
              a.name AS artist_name,
              tag.name AS tag_name,
              tag.tag_slug_id AS tag_slug_id,
              start,
              stop,
              vt.user_id,
              u.username,
              IFNULL(vtt.created_at, vt.created_at) as created_at
            FROM video_tag vt
                   LEFT JOIN video_tag_time vtt using (video_tag_id)
                   LEFT JOIN tag USING (tag_slug_id)
                   LEFT JOIN video v USING (video_youtube_id)
                   LEFT JOIN artist_video USING (video_youtube_id)
                   LEFT JOIN artist a USING (artist_slug_id)
                   LEFT JOIN user u ON vt.user_id = u.user_id
            ORDER BY created_at DESC");
    }

    public function find(string $youtube_id, string $tag_slug_id)
    {
        $stmt = $this->database->mysqli->prepare(
            "SELECT video_tag_id FROM video_tag WHERE video_youtube_id = ? AND tag_slug_id = ?");
        $stmt->bind_param('ss', $youtube_id, $tag_slug_id);
        $stmt->execute();
        $stmt->bind_result($video_tag_id);
        $stmt->fetch();

        return $video_tag_id;
    }

    public function set_completed(string $video_youtube_id, string $tag_slug_id): void
    {
        $stmt = $this->database->mysqli->prepare(
            "UPDATE video_tag SET is_complete = 1 WHERE video_youtube_id = ? AND tag_slug_id = ?"
        );

        if (!$stmt) {
            throw new \Exception($this->database->mysqli->error);
        }

        $stmt->bind_param('ss',$video_youtube_id,$tag_slug_id);

        if (!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }
    }

    public function set_uncompleted(string $video_youtube_id, string $tag_slug_id): void
    {
        $stmt = $this->database->mysqli->prepare(
            "UPDATE video_tag SET is_complete = 0 WHERE video_youtube_id = ? AND tag_slug_id = ?"
        );

        if (!$stmt) {
            throw new \Exception($this->database->mysqli->error);
        }

        $stmt->bind_param('ss',$video_youtube_id,$tag_slug_id);

        if (!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }
    }
}
