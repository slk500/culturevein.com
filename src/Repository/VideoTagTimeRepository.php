<?php

declare(strict_types=1);

namespace Repository;

use DTO\VideoTagCreate;
use DTO\VideoTagTimeCreate;
use Model\VideoTag;
use Repository\Base\Database;

final class VideoTagTimeRepository
{
    /**
     * @var Database
     */
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function save(VideoTagTimeCreate $video_tag_time_create): ?int
    {
        $stmt = $this->database->mysqli->prepare("INSERT INTO video_tag_time (video_tag_id, start, stop, user_id) VALUES (?, ?, ?, ?)");

        if (!$stmt) {
            throw new \Exception($this->database->mysqli->error);
        }

        $stmt->bind_param('iiii',
            $video_tag_time_create->video_tag_id,
                    $video_tag_time_create->start,
                    $video_tag_time_create->stop,
                    $video_tag_time_create->user_id
        );

        if (!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }

        return $stmt->insert_id;
    }


//
//    public function delete(int $video_tag_id): void
//    {
//        $stmt = $this->database->mysqli->prepare("DELETE FROM video_tag_time where video_tag_time_id = ?");
//
//        if (!$stmt) {
//            throw new \Exception($this->database->mysqli->error);
//        }
//
//        $stmt->bind_param("i", $video_tag_id);
//
//        if (!$stmt->execute()) {
//            throw new \Exception($stmt->error);
//        }
//
//    }
//
//    /**
//     * @return VideoTag[]
//     */
//    public function find_all_for_video(string $youtubeId): array
//    {
//        $stmt = $this->database->mysqli->prepare("
//    SELECT
//        vt.video_youtube_id,
//        vt.tag_slug_id,
//        vtt.video_tag_time_id,
//        vt.user_id,
//        tag.name as tag_name,
//        start,
//        stop
//    FROM video_tag vt
//        LEFT JOIN video_tag_time vtt using (video_tag_id)
//        LEFT JOIN tag USING (tag_slug_id)
//        LEFT JOIN video USING (video_youtube_id)
//        WHERE video.video_youtube_id = ?
//        ORDER BY tag.name, start
//        ");
//
//        $stmt->bind_param("s", $youtubeId);
//        $stmt->execute();
//
//        $result = $stmt->get_result();
//
//        $results = [];
//        while ($obj = mysqli_fetch_object($result, VideoTag::class)){
//            $results[] = $obj;
//        }
//        return $results;
//    }
//
//    public function find(int $video_tag_id): VideoTag
//    {
//        $stmt = $this->database->mysqli->prepare("
//        SELECT *, t.name as tag_name
//        FROM video_tag_time vt
//        LEFT JOIN tag t on vt.tag_slug_id = t.tag_slug_id
//        WHERE vt.video_tag_time_id = ?
//        ");
//
//        $stmt->bind_param("i", $video_tag_id);
//        $stmt->execute();
//
//        $result = $stmt->get_result();
//        $video_tag = mysqli_fetch_object($result, VideoTag::class);
//        $stmt->free_result();
//        $stmt->close();
//
//        return $video_tag;
//    }
}
