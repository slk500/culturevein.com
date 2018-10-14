<?php

use PHPUnit\Framework\TestCase;

class TagControllerTest extends TestCase
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
    public function create_tag()
    {
        $response = $this->client->post(
          'api/tags',
          [
              'json' => [
                  'video_id' => 3799,
                  'name' => 'chess',
                  'start' => 0,
                  'stop' => 25
              ]
          ]
        );

        $this->assertEquals('{"video_id":3799,"name":"chess","start":0,"stop":25,"tag_id":17}', $response->getBody()->getContents());
        $this->assertEquals(201,$response->getStatusCode());
    }
}
