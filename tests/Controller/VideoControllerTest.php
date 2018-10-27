<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Service\DatabaseHelper;

class VideoControllerTest extends TestCase
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    public static function setUpBeforeClass()
    {
        $databaseHelper = new DatabaseHelper();
        $databaseHelper->truncate_all_tables();
    }


    public function setUp()
    {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8000',
        ]);

    }

    /**
     * @test
     * @covers VideoController::create()
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

        $this->assertEquals(201,$response->getStatusCode());
    }
}
