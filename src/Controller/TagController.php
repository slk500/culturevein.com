<?php

declare(strict_types=1);

namespace Controller;

use Controller\Base\BaseController;
use Factory\VideoTagFactory;
use Repository\TagRepository;

class TagController extends BaseController
{
    private $tag_repository;

    private $tag_factory;

    public function __construct()
    {
        $this->tag_repository = new TagRepository();
        $this->tag_factory = new VideoTagFactory();
    }

    public function create(object $data)
    {
        $this->tag_factory->create($data);

        $this->responseCreated($data);
    }

    public function list()
    {
        $tags = $this->tag_repository->findAll();

        $this->response($tags);
    }

    public function show(string $slug)
    {
        $tag = $this->tag_repository->find($slug);

        $this->response($tag);
    }

    public function topTen()
    {
        $tags = $this->tag_repository->top();

        $this->response($tags);
    }

    public function newestTen()
    {
        $tags = $this->tag_repository->newestTen();

        $this->response($tags);
    }
}