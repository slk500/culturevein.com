<?php

declare(strict_types=1);

namespace Controller;

use ApiProblem\ApiProblem;
use Container;
use Controller\Base\BaseController;
use Repository\SubscribeRepository;
use Repository\TagRepository;

class TagController extends BaseController
{
    private TagRepository $tag_repository;

    private SubscribeRepository $subscribe_repository;

    public function __construct()
    {
        $container = new Container();
        $this->tag_repository = $container->get(TagRepository::class);
        $this->subscribe_repository = $container->get(SubscribeRepository::class);
    }

    public function list()
    {
        return normalize_tag_list_with_children(
            $this->tag_repository->find_all());
    }

    //use in select2
    public function list_without_relation()
    {
        return $this->tag_repository->find_all();
    }

    /**
     * @throws ApiProblem
     */
    public function show(string $slug): array
    {
        $tag = $this->tag_repository->find($slug);

        if (!$tag) {
            throw new ApiProblem(ApiProblem::NOT_FOUND);
        }

        $tag_videos = $this->tag_repository->find_videos($tag->slug_id);

        $result = tag_show_normalizer($tag_videos, $tag);

        return [
            'name' => $tag->name,
            'subscribers' => $this->subscribe_repository->get_subscribers_number($tag->slug_id),
            'videos' => $result
        ];
    }

    public function top_ten()
    {
        return $this->tag_repository->count_tag_in_videos();
    }

    public function newest_ten()
    {
        return $this->tag_repository->newest_ten();
    }
}