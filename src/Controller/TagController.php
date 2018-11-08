<?php

declare(strict_types=1);

namespace Controller;

use Controller\Base\BaseController;
use DTO\VideoTagCreate;
use Factory\VideoTagFactory;
use Repository\TagRepository;
use Repository\VideoTagRepository;

class TagController extends BaseController
{
    private $tag_repository;

    private $video_tag_factory;

    private $video_tag_repository;

    public function __construct()
    {
        $this->tag_repository = new TagRepository();
        $this->video_tag_repository = new VideoTagRepository();
        $this->video_tag_factory = new VideoTagFactory();
    }

    public function create(object $data): void
    {
        $video_tag_create = new VideoTagCreate(
            $data->youtube_id,
            $data->tag_name,
            $data->start,
            $data->stop
        );

        $this->video_tag_factory->create($video_tag_create);

        $this->response_created();
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