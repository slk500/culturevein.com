<?php

use Behat\Behat\Context\Context;
use DTO\VideoTagTimeCreate;
use Factory\VideoFactory;
use Factory\TagVideoFactory;
use Model\Tag;
use Repository\Base\Database;
use Repository\TagRepository;
use Repository\VideoTagTimeRepository;
use Tests\Builder\Video\VideoCreateBuilder;
use Tests\Builder\VideoTag\VideoTagCreateBuilder;
use Tests\DatabaseHelper;

class FeatureContext implements Context
{
    /**
     * @var TagRepository
     */
    private $tag_repository;

    /**
     * @var DatabaseHelper
     */
    private $database_helper;

    /**
     * @var VideoFactory
     */
    private $video_factory;

    /**
     * @var TagDescendantRepository
     */
    private $tag_descendant_repository;

    /**
     * @var TagVideoFactory
     */
    private $video_tag_factory;
    /**
     * @var VideoTagTimeRepository
     */
    private $video_tag_time_repository;

    public function __construct()
    {
        $container = new Container();
        $this->tag_repository = $container->get(TagRepository::class);
        $this->video_factory = $container->get(VideoFactory::class);
        $this->video_tag_factory = $container->get(TagVideoFactory::class);
        $this->video_tag_time_repository = $container->get(VideoTagTimeRepository::class);
        $this->database_helper = (new DatabaseHelper(new Database));
    }

    /**
     * @BeforeScenario
     */
    public function cleanDatabase()
    {
        $this->database_helper->truncate_all_tables();
    }

    /**
     * @Given /^there is an tag with name "([^"]*)"$/
     */
    public function thereIsAnTagWithName($tag_name)
    {
        $tag = new Tag($tag_name);

        $this->tag_repository->add($tag);
    }

    /**
     * @Given /^there is a video with artist name "([^"]*)" and name "([^"]*)"$/
     */
    public function thereIsAVideoWithArtistNameAndName(string $artist_name, string $name)
    {
        $video_create = (new VideoCreateBuilder())
            ->artist_name($artist_name)
            ->video_name($name)
            ->build();
        $this->video_factory->create($video_create);
    }

    /**
     * @Given /^this video have video tag "([^"]*)"$/
     */
    public function thisVideoHaveVideoTag($tag_name)
    {
        $video_tag_create = (new VideoTagCreateBuilder())
            ->tag_name($tag_name)
            ->build();

        $this->video_tag_factory->create($video_tag_create);
    }

    /**
     * @Given /^this video have video tag time "([^"]*)" with time start "([^"]*)" and stop "([^"]*)"$/
     */
    public function thisVideoHaveVideoTagTimeWithTimeStartAndStop(string $tag_name, int $start, int $stop)
    {
        $video_tag_create = new VideoTagTimeCreate(
            1,
            $start,
            $stop
        );

        $this->video_tag_time_repository->add($video_tag_create);
    }
}
