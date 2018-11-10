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
        $stmt = $this->database->mysqli->prepare("INSERT INTO video_tag (video_youtube_id, tag_slug_id, start, stop) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii",
            $video_tag_create->video_youtube_id,
             $video_tag_create->tag_slug_id,
                    $video_tag_create->start,
                    $video_tag_create->stop
        );
        $stmt->execute();
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
        vt.tag_slug_id,
        tvc.video_youtube_id is not null as complete
        FROM video_tag vt
        LEFT JOIN tag USING (tag_slug_id)
        LEFT JOIN video USING (video_youtube_id)
        LEFT JOIN video_tag_complete tvc USING (video_youtube_id)
        WHERE video.video_youtube_id = ?
        ORDER BY tag.name, vt.start
        ");

        $stmt->bind_param("s", $youtubeId);
        $stmt->execute();

        $result = $stmt->get_result();

        $results = [];
        while ($obj=mysqli_fetch_object($result, VideoTag::class)){
            $results[] = $obj;
        }
        return $results;
    }

    public function set_start_and_stop_null(int $video_tag_id)
    {
        $stmt = $this->database->mysqli->prepare(
            "UPDATE video_tag SET start = null, stop = null WHERE video_tag_id = ?"
        );

        $stmt->bind_param("i", $video_tag_id);
        $stmt->execute();
    }
}
