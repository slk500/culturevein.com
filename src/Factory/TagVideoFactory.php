<?php

declare(strict_types=1);

namespace Factory;

use Database\TagCommand;
use Database\TagVideoCommand;
use Model\Tag;
use Database\TagRepository;
use ValueObject\TagVideo;

class TagVideoFactory
{
    private TagRepository $tag_repository;

    private TagCommand $tag_command;

    private TagVideoCommand $tag_video_command;

    public function __construct(TagRepository $tag_repository, TagCommand $tag_command,
                                TagVideoCommand $tag_video_command
    )
    {
        $this->tag_repository = $tag_repository;
        $this->tag_command = $tag_command;
        $this->tag_video_command = $tag_video_command;
    }

    public function create(TagVideo $video_tag_create): ?int
    {
        $tag = $this->tag_repository->find($video_tag_create->tag_slug_id);

        if (!$tag) {
            $tag = new Tag($video_tag_create->tag_name);
            $this->tag_command->add($tag);
        }

        return $this->tag_video_command->add($video_tag_create);
    }
}