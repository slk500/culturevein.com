<?php

declare(strict_types=1);

namespace Controller;

use Container;
use Controller\Base\BaseController;
use Normalizer\TagNormalizer;
use Repository\TagRepository;

class TagController extends BaseController
{
    /**
     * @var TagRepository
     */
    private $tag_repository;

    /**
     * @var TagNormalizer
     */
    private $tag_normalizer;

    public function __construct()
    {
        $container = new Container();
        $this->tag_repository = $container->get(TagRepository::class);
        $this->tag_normalizer = new TagNormalizer();
    }

    public function list()
    {
        $tags = $this->tag_repository->find_all();

        $this->response($tags);
    }

    public function show(string $slug)
    {
        $tag_raw = $this->tag_repository->find($slug);
        $tag = $this->tag_normalizer->normalize($tag_raw);

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

    public function subscribe()
    {
        $this->tag_repository->subscribe();

        $this->response_created();
    }

    public function unsubscribe()
    {
        $this->tag_repository->usubscribe();

        $this->response_created();
    }
}