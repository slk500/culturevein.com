<?php

declare(strict_types=1);

namespace Repository;

use Repository\Base\Database;

final class VideoTagRepository
{
    /**
     * @var Database
     */
    private $database;

    private $video_tag_repository;

    public function __construct()
    {
        $this->database = new Database();
        $this->video_tag_repository = new VideoTagRepository();
    }

    public function create(object $data)
    {
        $stmt = $this->database->mysqli->prepare("INSERT INTO video_tag (tag_id, video_id, start, stop) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiii", $data->tag_id,$data->video_id, $data->start, $data->stop);
        $stmt->execute();

        return $this->database->mysqli->insert_id;
    }

    public function find_by_video(string $youtubeId)
    {
        $stmt = $this->database->mysqli->prepare("SELECT tag.name,
        GROUP_CONCAT(video_tag.start,'-',video_tag.stop) as times,
        tag.slug, tvc.video_id is not null as complete
        FROM video_tag
        JOIN tag USING (tag_id)
        JOIN video USING (video_id)
        LEFT JOIN video_tag_complete tvc on tag.tag_id = tvc.tag_id and tvc.video_id = video.video_id
        WHERE video.youtube_id = ?
        GROUP BY tag.name
        ORDER BY tag.name, video_tag.start");

        $stmt->bind_param("s", $youtubeId);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $stmt->free_result();
        $stmt->close();

        return $data;
    }

    public function clear_time(string $video_tag_id)
    {
        $stmt = $this->database->mysqli->prepare(
            "UPDATE video_tag SET start = null, stop = null WHERE tag_video_id = ?"
        );

        $stmt->bind_param("i", $video_tag_id);
        $stmt->execute();
    }
}
