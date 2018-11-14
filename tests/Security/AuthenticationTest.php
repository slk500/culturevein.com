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
        $this->markTestSkipped();

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

        (new UserRepository())->create($userData);

        $user = (new UserRepository())->find('mario@o2.pl');
    }

    /**
     * @test
     */
    public function create_video_tag()
    {
        $tag = new Tag('tag name');

        (new TagRepository())->create($tag);

        $video_create = (new VideoCreateBuilder())->build();
        (new VideoFactory())->create($video_create);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        (new VideoTagFactory())->create($video_tag_create);

        $video_tag_repository = new VideoTagRepository();

        $result = $video_tag_repository->find_all_for_video($video_create->youtube_id);
    }
}
