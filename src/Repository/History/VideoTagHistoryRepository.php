<?php

declare(strict_types=1);

namespace Repository\History;

use DTO\VideoTagCreate;
use Model\VideoTag;
use Repository\Base\Database;

final class VideoTagHistoryRepository
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
                  FROM video_tag_history
         ";

        $data = $this->database->fetch($query);

        return $data;
    }
}
