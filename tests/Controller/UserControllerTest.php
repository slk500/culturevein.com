<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Service\DatabaseHelper;

class UserControllerTest extends TestCase
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    public static function setUpBeforeClass()
    {
        (new DatabaseHelper())->truncate_all_tables();
    }

    public function setUp()
    {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8000',
        ]);
    }

    /**
     * @test
     * @covers UserController::create()
     */
    public function create_user()
    {
        $response = $this->client->post(
            'api/users',
            [
                'json' => [
                    'email' => 'slawomir.grochowski@gmail.com',
                    'password' => 'password',
                    'username' => 'slk500'
                ]
            ]
        );

        $this->assertEquals(201,$response->getStatusCode());
        
        $content = $response->getBody()->getContents();
        $result = json_decode($content, true);
        $this->assertArrayHasKey('token', $result);
        $this->assertNotEmpty($result['token']);
    }
}


