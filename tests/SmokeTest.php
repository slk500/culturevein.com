<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class SmokeTest extends TestCase
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
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $response = $this->client->request('GET', $url);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function urlProvider()
    {
        yield ['/api/tags'];
        yield ['/api/videos'];
    }
}
