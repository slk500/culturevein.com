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

        $this->assertEquals('{"artist":"Burak Yeter","name":"Tuesday ft. Danelle Sandoval","youtube_id":"Y1_VsyLAGuk","artist_id":1,"video_id":1}',
            $response->getBody()->getContents());
        $this->assertEquals(201,$response->getStatusCode());
    }
}
