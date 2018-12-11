<?php

declare(strict_types=1);

namespace Repository;

use DTO\VideoTagCreate;
use DTO\VideoTagRaw;
use Model\VideoTag;
use Repository\Base\Database;

final class VideoTagRepository
{
    /**
     * @var Database
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function save(VideoTagCreate $video_tag_create): ?int
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

    public function delete(string $video_youtube_id, string $tag_slug_id): void
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

    /**
     * @return VideoTagRaw[]
     */
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

        $results = [];
        while ($obj = mysqli_fetch_object($result, VideoTagRaw::class)){
            $results[] = $obj;
        }
        return $results;
    }

    public function find_all(): array
    {
        $query =
            "SELECT
              vt.video_youtube_id,
              v.name   AS video_name,
              a.name AS artist_name,
              tag.name AS tag_name,
              start,
              stop,
              vt.user_id,
              u.username,
              vtt.created_at
            FROM video_tag vt
                   LEFT JOIN video_tag_time vtt using (video_tag_id)
                   LEFT JOIN tag USING (tag_slug_id)
                   LEFT JOIN video v USING (video_youtube_id)
                   LEFT JOIN artist_video USING (video_youtube_id)
                   LEFT JOIN artist a USING (artist_slug_id)
                   LEFT JOIN user u ON vt.user_id = u.user_id
            ORDER BY vtt.created_at DESC";

        $data = $this->database->fetch($query);

        return $data;
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

    public function set_is_complete(string $video_youtube_id, string $tag_slug_id, bool $is_complete): void
    {
        $is_complete = $is_complete ? 1 : 0;

        $stmt = $this->database->mysqli->prepare(
            "UPDATE video_tag SET is_complete = ? WHERE video_youtube_id = ? AND tag_slug_id = ?"
        );

        if (!$stmt) {
            throw new \Exception($this->database->mysqli->error);
        }

        $stmt->bind_param('iss', $is_complete, $video_youtube_id, $tag_slug_id);

        if (!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }
    }
}
