<?php

declare(strict_types=1);

namespace Controller;

use Container;
use Controller\Base\BaseController;
use Model\TagDescendant;
use Repository\TagDescendantRepository;
use Repository\TagRepository;
use Service\TokenService;

class VideoTagDescendantController extends BaseController
{
    private $token_service;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var TagRepository
     */
    private $tag_repository;

    /**
     * @var TagDescendantRepository
     */
    private $tag_descendant_repository;

    public function __construct()
    {
        $this->container = new Container();
        $this->token_service = new TokenService();
        $this->tag_repository = $this->container->get(TagRepository::class);
        $this->tag_descendant_repository = $this->container->get(TagDescendantRepository::class);
    }

    public function create()
    {
        $body = $this->get_body();

        $tag_descendant = new TagDescendant(
            $body->tag_descendant,
            $body->tag_ancestor
        );

        $this->tag_descendant_repository->save($tag_descendant);

        return $this->response_created($tag_descendant);
    }

    public function descendants(string $slug)
    {
        return $this->response(['data' => $this->tag_repository->find_descendants_simple($slug)]);
    }

    public function ancestors(string $slug)
    {
        return $this->response(['data' => $this->tag_repository->find_ancestors($slug)]);
    }
}

