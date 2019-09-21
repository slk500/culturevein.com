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


    public function __construct()
    {
        $container = new Container();
        (new DatabaseHelper($container->get(Database::class)))
            ->truncate_all_tables();

        $this->tag_repository = $container->get(TagRepository::class);
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
