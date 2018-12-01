<?php

declare(strict_types=1);

namespace Tests\Service;

use PHPUnit\Framework\TestCase;
use Repository\Base\Database;
use Service\DatabaseHelper;

class DatabaseHelperTest extends TestCase
{
    /**
     * @test
     */
    public function check_is_all_tables_are_empty()
    {
        $databaseHelper = new DatabaseHelper(new Database());

        $databaseHelper->truncate_all_tables();

        $result = $databaseHelper->are_tables_empty();

        $this->assertTrue($result);
    }
}
