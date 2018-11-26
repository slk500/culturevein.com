<?php

declare(strict_types=1);

namespace Tests\Security;

use Factory\VideoFactory;
use Factory\VideoTagFactory;
use Model\Tag;
use Model\User;
use PHPUnit\Framework\TestCase;
use Repository\TagRepository;
use Repository\UserRepository;
use Repository\VideoTagRepository;
use Service\DatabaseHelper;
use Tests\Builder\VideoCreateBuilder;
use Tests\Builder\VideoTagCreateBuilder;

class AuthenticationTest extends TestCase
{
    public function setUp()
    {
        (new DatabaseHelper())->truncate_all_tables();
    }

    /**
     * @test
     */
    public function verify()
    {
        $password_encrypted = password_hash('qqq', PASSWORD_BCRYPT);

        $this->assertTrue(password_verify('qqq', $password_encrypted));
    }

    /**
     * @test
     */
    public function auth()
    {
        $password_encrypted = password_hash('qqq', PASSWORD_BCRYPT);

        $userData = new User(
            'mario@o2.pl',
            $password_encrypted,
            'mario'
        );

        (new UserRepository())->save($userData);

        $user = (new UserRepository())->find('mario@o2.pl');

        $this->assertInstanceOf(User::class, $user);
    }
}

