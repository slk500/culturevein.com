<?php

declare(strict_types=1);

namespace Tests\Security;

use Container;
use Model\User;
use PHPUnit\Framework\TestCase;
use Database\Base\Database;
use Database\UserRepository;
use Tests\DatabaseHelper;

class AuthenticationTest extends TestCase
{

    /**
     * @var UserRepository
     */
    private $user_repository;

    public function setUp()
    {
        $container = new Container();
        (new DatabaseHelper($container->get(Database::class)))
            ->truncate_all_tables();

        $this->user_repository = $container->get(UserRepository::class);
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

        $this->user_repository->add($userData);

        $user = $this->user_repository->find('mario@o2.pl');

        $this->assertInstanceOf(User::class, $user);
    }
}

