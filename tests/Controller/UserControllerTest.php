<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Repository\Base\Database;
use Service\DatabaseHelper;

class UserControllerTest extends TestCase
{
    private Client $client;

    public static function setUpBeforeClass()
    {
        $container = new \Container();
        (new DatabaseHelper($container->get(Database::class)))
            ->truncate_all_tables();
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
        $this->assertNotEmpty($result['data']['token']);
    }
}


