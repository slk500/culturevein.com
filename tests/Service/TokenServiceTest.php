<?php

declare(strict_types=1);

namespace Tests\Service;

use PHPUnit\Framework\TestCase;
use Service\TokenService;

class TokenServiceTest extends TestCase
{
    /**
     * @var TokenService
     */
    private $token_service;

    public function setUp()
    {
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
}
