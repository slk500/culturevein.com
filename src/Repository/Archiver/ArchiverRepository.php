<?php

declare(strict_types=1);


namespace Repository\Archiver;


use Repository\Base\Database;

final class ArchiverRepository
{
    /**
     * @var Database
     */
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }


    //todo should be one query VIDEO_TAG
    public function archive(int $video_tag_id, ?int $user_id = null): void
    {
        $stmt = $this->database->mysqli->prepare("
        INSERT INTO video_tag_history (video_tag_id, video_youtube_id, tag_slug_id, user_id, start, stop, description, created_at, deleted_by)  
        SELECT video_tag_time_id,video_youtube_id,tag_slug_id, user_id, start, stop, description, created_at, ? 
        FROM video_tag_time WHERE video_tag_time_id = ?");
        if (!$stmt) {
            throw new \Exception($this->database->mysqli->error);
        }

        $stmt->bind_param("ii", $user_id, $video_tag_id);
        if (!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }
    }

      //todo should be one query VIDEO_TAG_TIME
//    public function archive(int $video_tag_id, ?int $user_id = null): void
//    {
//        $stmt = $this->database->mysqli->prepare("
//        INSERT INTO video_tag_history (video_tag_id, video_youtube_id, tag_slug_id, user_id, start, stop, description, created_at, deleted_by)
//        SELECT video_tag_time_id,video_youtube_id,tag_slug_id, user_id, start, stop, description, created_at, ?
//        FROM video_tag_time WHERE video_tag_time_id = ?");
//        if (!$stmt) {
//            throw new \Exception($this->database->mysqli->error);
//        }
//
//        $stmt->bind_param("ii", $user_id, $video_tag_id);
//        if (!$stmt->execute()) {
//            throw new \Exception($stmt->error);
//        }
//    }

}