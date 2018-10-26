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

    public function __construct()
    {
        $this->database = new Database();
    }

    public function create(object $data)
    {
        $stmt = $this->database->mysqli->prepare("INSERT INTO video_tag (tag_id, video_id, start, stop) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiii", $data->tag_id,$data->video_id, $data->start, $data->stop);
        $stmt->execute();

        return $this->database->mysqli->insert_id;
    }
}
