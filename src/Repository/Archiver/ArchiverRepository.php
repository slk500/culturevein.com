<?php

declare(strict_types=1);


namespace Repository\Archiver;


use Repository\Base\Database;

final class ArchiverRepository
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function archive_video_tag(string $video_youtube_id, string $tag_slug_id, ?int $user_id = null): void
    {
        $stmt = $this->database->mysqli->prepare("
        INSERT INTO video_tag_history (video_tag_id, video_youtube_id, tag_slug_id, user_id, is_complete, created_at, deleted_by)  
        SELECT video_tag_id, video_youtube_id, tag_slug_id, user_id, is_complete, created_at, ? 
        FROM video_tag WHERE video_youtube_id = ? AND tag_slug_id = ?");

        if (!$stmt) {
            throw new \Exception($this->database->mysqli->error);
        }

        $stmt->bind_param('iss', $user_id, $video_youtube_id, $tag_slug_id);
        if (!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }
    }

    //todo add who deleted it
    public function archive_video_tag_time(int $video_tag_id): void
    {
        $stmt = $this->database->mysqli->prepare("
        INSERT INTO video_tag_time_history (video_tag_time_id, video_tag_id, user_id, start, stop, created_at, deleted_at)   
        SELECT video_tag_time_id, video_tag_id, user_id, start, stop, created_at, now() 
        FROM video_tag_time WHERE video_tag_time_id = ? ");

        if (!$stmt) {
            throw new \Exception($this->database->mysqli->error);
        }

        $stmt->bind_param('i', $video_tag_id);
        if (!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }
    }


}