<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Database\Base\Database;

class DatabaseHelperTest extends TestCase
{
    /**
     * @var DatabaseHelper
     */
    private $database_helper;

    public function setUp()
    {
        $this->database_helper = new DatabaseHelper(new Database());
    }

    /**
     * @test
     */
    public function check_is_all_tables_are_empty()
    {
        $this->markTestSkipped('have to find query to list all not empty tables');
        $this->database_helper->truncate_all_tables();

        $result = $this->database_helper->are_tables_empty();

        $this->assertTrue($result);
    }

    /**
     * @test
     * @coverage DatabaseHelper::get_all_tables_name
     */
    public function get_all_tables_name()
    {
        $tables_names = $this->database_helper->get_all_tables_names();

        $this->assertSame('artist', $tables_names[0]);
    }
}
