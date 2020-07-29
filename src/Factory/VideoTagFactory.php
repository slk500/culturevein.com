<?php

declare(strict_types=1);

namespace Factory;

use DTO\VideoTagCreate;
use Model\Tag;
use Repository\TagRepository;
use Repository\VideoTagRepository;

class VideoTagFactory
{
    private $video_tag_repository;
    private $tag_repository;

    public function __construct(TagRepository $tag_repository, VideoTagRepository $video_tag_repository)
    {
        $this->tag_repository = $tag_repository;
        $this->video_tag_repository = $video_tag_repository;
    }

    public function create(VideoTagCreate $video_tag_create): ?int
    {
        $tag = $this->tag_repository->find($video_tag_create->tag_slug_id);

        if (!$tag) {
            $tag = new Tag($video_tag_create->tag_name);
            $this->tag_repository->add($tag);
        }

        return $this->video_tag_repository->add($video_tag_create);
    }
}