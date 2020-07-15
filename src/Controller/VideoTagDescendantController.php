<?php

declare(strict_types=1);

namespace Controller;

use Container;
use Controller\Base\BaseController;
use Repository\TagRepository;

class VideoTagDescendantController extends BaseController
{
    private Container $container;

    private TagRepository $tag_repository;

    public function __construct()
    {
        $this->container = new Container();
        $this->tag_repository = $this->container->get(TagRepository::class);
    }

    public function descendants(string $slug)
    {
        return $this->tag_repository->find_descendants_simple($slug);
    }

    public function ancestors(string $slug)
    {
        return $this->tag_repository->find_ancestors($slug);
    }
}

