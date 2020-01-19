<?php

declare(strict_types=1);

namespace Controller;

use Container;
use Controller\Base\BaseController;
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

    public function __construct()
    {
        $this->container = new Container();
        $this->token_service = new TokenService();
        $this->tag_repository = $this->container->get(TagRepository::class);
    }

    public function descendants(string $slug)
    {
        return $this->response($this->tag_repository->find_descendants_simple($slug));
    }

    public function ancestors(string $slug)
    {
        return $this->response($this->tag_repository->find_ancestors($slug));
    }
}

