<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class VideoControllerTest extends TestCase
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    public function setUp()
    {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8000',
        ]);
    }

    /**
     * @test
     */
    public function create_video()
    {
        $response = $this->client->post(
            'api/videos',
            [
                'json' => [
                    'artist' => 'Burak Yeter',
                    'name' => 'Tuesday ft. Danelle Sandoval',
                    'youtube_id' => 'Y1_VsyLAGuk'
                ]
            ]
        );

        $this->assertEquals('{"video_id":3799,"name":"chess","start":0,"stop":25,"tag_id":17}', $response->getBody()->getContents());
        $this->assertEquals(201,$response->getStatusCode());
    }
}
