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

        $this->response_created($data);
    }

    public function list()
    {
        $tags = $this->tag_repository->find_all();

        $this->response($tags);
    }

    public function show(string $slug)
    {
        $tag = $this->tag_repository->find($slug);

        $this->response($tag);
    }

    public function top_ten()
    {
        $tags = $this->tag_repository->top();

        $this->response($tags);
    }

    public function newest_ten()
    {
        $tags = $this->tag_repository->newest_ten();

        $this->response($tags);
    }
}