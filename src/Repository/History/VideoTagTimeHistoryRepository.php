<?php

declare(strict_types=1);

namespace Repository\History;

use Repository\Base\Database;

final class VideoTagTimeHistoryRepository
{
    /**
     * @var Database
     */
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function find_all(): ?array
    {
        $query = "SELECT *
                  FROM video_tag_time_history
         ";

        $data = $this->database->fetch($query);

        return $data;
    }
}
