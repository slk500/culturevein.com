<?php

declare(strict_types=1);

namespace Tests\Service;

use PHPUnit\Framework\TestCase;
use Service\DatabaseHelper;

class DatabaseHelperTest extends TestCase
{
    /**
     * @test
     */
    public function check_is_all_tables_are_empty()
    {
        $databaseHelper = new DatabaseHelper();

        $databaseHelper->truncate_tables([
            'artist',
            'artist_video',
            'tag',
            'tag_video',
            'tag_video_complete',
            'user',
            'video'
        ]);

        $result = $databaseHelper->are_tables_empty();

        $this->assertTrue($result);
    }
}
