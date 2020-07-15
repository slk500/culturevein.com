<?php

declare(strict_types=1);

namespace Repository\History;

use Repository\Base\Repository;

final class VideoTagTimeHistoryRepository extends Repository
{
    public function find_all(): ?array
    {
        $query = "SELECT * FROM video_tag_time_history";
        return $this->database->fetch($query);
    }
}
