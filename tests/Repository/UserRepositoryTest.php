<?php

declare(strict_types=1);

namespace Tests\Repository;

use Model\User;
use PHPUnit\Framework\TestCase;
use Repository\UserRepository;
use Service\DatabaseHelper;

class UserRepositoryTest extends TestCase
{
    /**
     * @var UserRepository
     */
    private $user_repository;

    public static function setUpBeforeClass()
    {
        (new DatabaseHelper())->truncate_all_tables();
    }

    public function setUp()
    {
        $this->user_repository = new UserRepository();
    }

    /**
     * @test
     */
    public function create_and_find()
    {
        $email = 'slawomir.grochowski@gmail.com';

        $user = new User($email, 'password','slk500');

        $user_id = $this->user_repository->create($user);

        $user = $this->user_repository->find($email);

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame($email, $user->email);
        $this->assertSame(1, $user_id);

    }

    /**
     * @test
     */
    public function find_when_email_not_in_database()
    {
        $email = 'slawomir.grochowski@gmail.com';

        $user = new User($email, 'password','slk500');

        $this->user_repository->create($user);

        $user = $this->user_repository->find('other@email.com');

        $this->assertNull($user);
    }
}
