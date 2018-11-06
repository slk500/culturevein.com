<?php

declare(strict_types=1);

namespace Factory;

use DTO\VideoTagCreate;
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

    public function create(VideoTagCreate $video_tag_create): void
    {
        $tag_slug_id = $this->tag_repository->find_slug_id_by_name($video_tag_create->tag_name);

        if (!$tag_slug_id) {
            $this->tag_repository->create($video_tag_create->tag_name, $video_tag_create->tag_slug_id);
        }

        $this->video_tag_repository->create($video_tag_create);
    }
}