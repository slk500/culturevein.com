<?php

namespace Tests\Repository;

use PHPUnit\Framework\TestCase;
use Repository\Database;

class DatabaseTest extends TestCase
{
    /**
     * @test
     */
    public function exe()
    {
        $database = new Database();

        $database->execute('SET FOREIGN_KEY_CHECKS = 0;TRUNCATE artist;TRUNCATE artist_video;TRUNCATE tag;TRUNCATE tag_video;TRUNCATE tag_video_complete;TRUNCATE user;TRUNCATE video;SET FOREIGN_KEY_CHECKS = 1;');


    }
}
