<?php

declare(strict_types=1);

namespace Tests\Service;

use PHPUnit\Framework\TestCase;
use Service\YouTube;

class YouTubeTest extends TestCase
{
    /**
     * @test
     */
    public function get_artist_and_title()
    {
        $youTube = new YouTube();

        $result = $youTube->getArtistAndTitle('wQRV5omnBBU');

        $this->assertEquals('Martin Solveig', $result['artist']);
        $this->assertEquals('Do It Right ft. Tkay Maidza', $result['title']);
    }
}
