<?php

declare(strict_types=1);

namespace Tests\Service;

use PHPUnit\Framework\TestCase;
use Service\YouTubeService;

class YouTubeTest extends TestCase
{
    /**
     * @internet_connection
     * @test
     */
    public function get_artist_and_title()
    {
        $youTube = new YouTubeService();

        $result = $youTube->get_artist_and_title('wQRV5omnBBU');

        $this->assertEquals('Martin Solveig', $result['artist']);
        $this->assertEquals('Do It Right (Official Video) ft. Tkay Maidza', $result['title']);
    }

    /**
     * @internet_connection
     * @test
     */
    public function get_duration()
    {
        $youTube = new YouTubeService();

        $result = $youTube->get_duration('wQRV5omnBBU');

        $this->assertEquals(186, $result);
    }
}
