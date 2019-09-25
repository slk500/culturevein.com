<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Model\Tag;
use Repository\Base\Database;
use Repository\TagRepository;
use Service\DatabaseHelper;

/**
 * Defines application features from the specific context.
 */
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


    public function __construct()
    {
        $container = new Container();
        $this->tag_repository = $container->get(TagRepository::class);
        $this->database_helper = (new DatabaseHelper($container->get(Database::class)));
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

        $this->tag_repository->save($tag);
    }
}
