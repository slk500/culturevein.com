<?php

declare(strict_types=1);

namespace Tests\Repository;

use Container;
use Model\User;
use PHPUnit\Framework\TestCase;
use Repository\Base\Database;
use Repository\UserRepository;
use Tests\DatabaseHelper;

class UserRepositoryTest extends TestCase
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
    public function create_and_find()
    {
        $email = 'slawomir.grochowski@gmail.com';

        $user = new User($email, 'password','slk500');

        $user_id = $this->user_repository->save($user);

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

        $this->user_repository->save($user);

        $user = $this->user_repository->find('other@email.com');

        $this->assertNull($user);
    }
}
