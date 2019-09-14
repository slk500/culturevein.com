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
        return $this->response(
            $this->tag_repository->find_all()
        );
    }

    public function show(string $slug)
    {
        return $this->response(
            $this->tag_normalizer->normalize(
                $this->tag_repository->find($slug)
            )
        );
    }

    public function descendents(string $slug)
    {
        return $this->response(['data' => $this->tag_repository->find_descendents($slug)]);
    }

    public function top_ten()
    {
        return $this->response(
            $this->tag_repository->top()
        );
    }

    public function newest_ten()
    {
        return $this->response(
            $this->tag_repository->newest_ten()
        );
    }

    public function subscribe()
    {
        $this->tag_repository->subscribe();

        return $this->response_created();
    }

    public function unsubscribe()
    {
        $this->tag_repository->usubscribe();

        return $this->response_created();
    }
}