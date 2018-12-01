<?php

declare(strict_types=1);

namespace Repository\History;

use Repository\Base\Database;

final class VideoTagHistoryRepository
{
    /**
     * @var Database
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function find_all(): ?array
    {
        $query = "SELECT *
                  FROM video_tag_history
         ";

        $data = $this->database->fetch($query);

        return $data;
    }
}
