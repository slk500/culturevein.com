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

    public function __construct()
    {
        $this->tag_repository = new TagRepository();
        $this->video_tag_repository = new VideoTagRepository();
    }

    public function create(VideoTagCreate $video_tag_create): void
    {
        $tag_slug_id = $this->tag_repository->find_slug_id_by_name($video_tag_create->tag_name);

        if (!$tag_slug_id) {
            $tag = new Tag($video_tag_create->tag_name);
            $this->tag_repository->create($tag);
        }

        $video_tag_id = $this->video_tag_repository->find_video_tag_id_without_time(
            $video_tag_create->video_youtube_id, $video_tag_create->tag_slug_id);

        if($video_tag_id){
            $this->video_tag_repository->update_time($video_tag_id, $video_tag_create->start, $video_tag_create->stop);
        }else{
            $this->video_tag_repository->create($video_tag_create);
        }
    }
}