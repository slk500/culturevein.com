<?php

declare(strict_types=1);

namespace Tests\Service;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use PHPUnit\Framework\TestCase;
use Service\TokenService;
use Symfony\Component\Dotenv\Dotenv;

class TokenServiceTest extends TestCase
{
    /**
     * @var TokenService
     */
    private $token_service;

    /**
     * @var string
     */
    private $token_secret;

    public function setUp()
    {
        $parameters = include(__DIR__.'/../../config/parameters.php');
        $this->token_secret = $parameters['token_secret'];
        $this->token_service = new TokenService();
    }

    /**
     * @test
     */
    public function create_token()
    {
       $token = $this->token_service->create_token(10);

       $user_id = $this->token_service->decode_user_id($token);

       $this->assertSame(10, $user_id);
    }

    /**
     * @test
     */
    public function token_expired()
    {
        $this->expectException(ExpiredException::class);

        $payload = [
            "user_id" => 1,
            "exp" => time() - 100
        ];


        $token = JWT::encode($payload, $this->token_secret);

        $decoded = JWT::decode($token, $this->token_secret, array('HS256'));

    }
}
