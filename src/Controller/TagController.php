<?php

declare(strict_types=1);

namespace Controller;

use Controller\Base\BaseController;
use DTO\VideoTagCreate;
use Factory\VideoTagFactory;
use Repository\TagRepository;
use Repository\VideoTagRepository;
use Service\TokenService;

class TagController extends BaseController
{
    private $tag_repository;

    public function __construct()
    {
        $this->tag_repository = new TagRepository();
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