<?php

declare(strict_types=1);

namespace Tests\Repository;

use Container;
use Factory\VideoFactory;
use Model\Tag;
use Model\User;
use PHPUnit\Framework\TestCase;
use Repository\ArtistRepository;
use Repository\Base\Database;
use Repository\SubscribeRepository;
use Repository\TagRepository;
use Repository\UserRepository;
use Repository\TagVideoRepository;
use Tests\DatabaseHelper;
use Tests\Builder\Video\VideoCreateBuilder;
use Tests\Builder\VideoTag\VideoTagCreateBuilder;

class SubscribeRepositoryTest extends TestCase
{
    /**
     * @var SubscribeRepository
     */
    private $subscribe_repository;

    /**
     * @var TagVideoRepository
     */
    private $video_tag_repository;

    /**
     * @var UserRepository
     */
    private $user_repository;

    /**
     * @var VideoFactory
     */
    private $video_factory;

    /**
     * @var TagRepository
     */
    private $tag_repository;

    public function setUp()
    {
        $container = new Container();
        (new DatabaseHelper($container->get(Database::class)))
            ->truncate_all_tables();

        $this->subscribe_repository = $container->get(SubscribeRepository::class);
        $this->video_tag_repository = $container->get(TagVideoRepository::class);
        $this->user_repository = $container->get(UserRepository::class);
        $this->video_factory = $container->get(VideoFactory::class);
        $this->tag_repository = $container->get(TagRepository::class);
    }

    /**
     * @test
     */
    public function create_and_check_if_exist()
    {
        $user = new User('slawomir.grochowski@gmail.com', 'password', 'slk');

        $this->user_repository->add($user);

        $video_create = (new VideoCreateBuilder())->build();
        $this->video_factory->create($video_create);

        $tag = new Tag('video game');
        $this->tag_repository->add($tag);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        $this->video_tag_repository->add($video_tag_create);

        $result = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);

        $this->assertNotEmpty($result);

        $this->subscribe_repository->subscribe_tag($tag->slug_id, 1);

        $result = $this->subscribe_repository->is_tag_subscribed_by_user($tag->slug_id, 1);

        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function delete()
    {
        $user = new User('slawomir.grochowski@gmail.com', 'password', 'slk');

        $this->user_repository->add($user);

        $video_create = (new VideoCreateBuilder())->build();
        $this->video_factory->create($video_create);

        $tag = new Tag('video game');
        $this->tag_repository->add($tag);

        $video_tag_create = (new VideoTagCreateBuilder())->build();
        $this->video_tag_repository->add($video_tag_create);

        $result = $this->video_tag_repository->find_all_for_video($video_create->youtube_id);

        $this->assertNotEmpty($result);

        $this->subscribe_repository->subscribe_tag($tag->slug_id, 1);

        $result = $this->subscribe_repository->is_tag_subscribed_by_user($tag->slug_id, 1);

        $this->assertTrue($result);

        $this->subscribe_repository->unsubscribe_tag($tag->slug_id, 1);


    }
}
