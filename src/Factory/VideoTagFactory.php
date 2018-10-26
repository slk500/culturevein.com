<?php

declare(strict_types=1);

namespace Factory;

use Repository\TagRepository;
use Repository\VideoTagRepository;

class VideoTagFactory
{
    private $video_tag_repository;
    private $tag_repository;

    public function __construct()
    {
        $this->tag_repository = new TagRepository();
        $this->video_tag_repository = new VideoTagRepository();
    }

    public function create(object $data)
    {
        $tag_id = $this->tag_repository->find_id_by_name($data->name);

        if (!$tag_id) {
            $tag_id = $this->tag_repository->create($data->name);
        }

        $data->tag_id = $tag_id;

        $this->video_tag_repository->create($data);

        return $data;
    }
}