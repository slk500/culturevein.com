<?php

declare(strict_types=1);

namespace Repository;

use DTO\VideoTagCreate;
use Model\VideoTag;
use Repository\Base\Database;

final class VideoTagRepository
{
    /**
     * @var Database
     */
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function create(VideoTagCreate $video_tag_create): void
    {
        $stmt = $this->database->mysqli->prepare("INSERT INTO video_tag (video_youtube_id, tag_slug_id, start, stop, user_id) VALUES (?, ?, ?, ?, ?)");

        if (!$stmt) {
            throw new \Exception($this->database->mysqli->error);
        }

        $stmt->bind_param("ssiii",
            $video_tag_create->video_youtube_id,
             $video_tag_create->tag_slug_id,
                    $video_tag_create->start,
                    $video_tag_create->stop,
                    $video_tag_create->user_id
        );

        if (!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }

    }

    //todo should be one query
    public function archive(int $video_tag_id, ?int $user_id = null): void
    {
        $stmt = $this->database->mysqli->prepare("
        INSERT INTO video_tag_history (video_tag_id, video_youtube_id, tag_slug_id, user_id, start, stop, description, created_at, deleted_by)  
        SELECT video_tag_id,video_youtube_id,tag_slug_id, user_id, start, stop, description, created_at, ? 
        FROM video_tag WHERE video_tag_id = ?");
        if (!$stmt) {
            throw new \Exception($this->database->mysqli->error);
        }

        $stmt->bind_param("ii", $user_id, $video_tag_id);
        if (!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }
    }

    public function delete(int $video_tag_id): void
    {
        $stmt = $this->database->mysqli->prepare("DELETE FROM video_tag where video_tag_id = ?");

        if (!$stmt) {
            throw new \Exception($this->database->mysqli->error);
        }

        $stmt->bind_param("i", $video_tag_id);

        if (!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }

    }

    public function is_only_one(int $video_tag_id): bool
    {
        $stmt = $this->database->mysqli->prepare(
            "SELECT count(*) as count
                    FROM video_tag
                    WHERE ROW(video_youtube_id, tag_slug_id) = 
                    (SELECT video_youtube_id, tag_slug_id FROM video_tag WHERE video_tag_id = ?);"
        );

        $stmt->bind_param("i", $video_tag_id);
        $stmt->execute();

        $result = $stmt->get_result()
            ->fetch_object();

        return $result->count === 1;
    }

    /**
     * @return VideoTag[]
     */
    public function find_all_for_video(string $youtubeId): array
    {
        $stmt = $this->database->mysqli->prepare("
        SELECT 
        vt.video_tag_id,
        tag.name as tag_name, 
        vt.video_youtube_id,
        start,
        stop,
        vt.user_id,
        vt.tag_slug_id,
        tvc.video_youtube_id is not null as complete
        FROM video_tag vt
        LEFT JOIN tag USING (tag_slug_id)
        LEFT JOIN video USING (video_youtube_id)
        LEFT JOIN video_tag_complete tvc USING (video_youtube_id, tag_slug_id)
        WHERE video.video_youtube_id = ?
        ORDER BY tag.name, vt.start
        ");

        $stmt->bind_param("s", $youtubeId);
        $stmt->execute();

        $result = $stmt->get_result();

        $results = [];
        while ($obj = mysqli_fetch_object($result, VideoTag::class)){
            $results[] = $obj;
        }
        return $results;
    }

    public function set_start_and_stop_null(int $video_tag_id): void
    {
        $stmt = $this->database->mysqli->prepare(
            "UPDATE video_tag SET start = null, stop = null WHERE video_tag_id = ?"
        );

        $stmt->bind_param("i", $video_tag_id);
        $stmt->execute();
    }

    public function find(int $video_tag_id): VideoTag
    {
        $stmt = $this->database->mysqli->prepare("
        SELECT *, t.name as tag_name
        FROM video_tag vt
        LEFT JOIN tag t on vt.tag_slug_id = t.tag_slug_id
        WHERE vt.video_tag_id = ?
        ");

        $stmt->bind_param("i", $video_tag_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $video_tag = mysqli_fetch_object($result, VideoTag::class);
        $stmt->free_result();
        $stmt->close();

        return $video_tag;
    }
}
