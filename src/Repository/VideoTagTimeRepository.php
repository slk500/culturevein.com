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

    public function __construct(Database $database)
    {
        $this->database = $database;
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

    public function delete(int $video_tag_time_id): void
    {
        $stmt = $this->database->mysqli->prepare("DELETE FROM video_tag_time WHERE video_tag_time_id = ?");

        if (!$stmt) {
            throw new \Exception($this->database->mysqli->error);
        }

        $stmt->bind_param('i', $video_tag_time_id);

        if (!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }
    }
}
