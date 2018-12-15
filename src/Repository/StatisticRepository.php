<?php

declare(strict_types=1);

namespace Repository;

use Cocur\Slugify\Slugify;
use Repository\Base\Database;

final class StatisticRepository
{
    /**
     * @var Database
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }
}