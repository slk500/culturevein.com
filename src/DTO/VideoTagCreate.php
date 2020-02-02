<?php

declare(strict_types=1);

namespace DTO;


use Cocur\Slugify\Slugify;

class VideoTagCreate
{
    public string $video_youtube_id;

    public string $tag_name;

    public string $tag_slug_id;

    public ?int $user_id;

    public function __construct(string $video_youtube_id, string $tag_name, ?int $user_id = null)
    {
        $trim_tag_name =  trim($tag_name);

        if (empty($trim_tag_name)){
            throw new \Exception('Tag name is empty!');
        }

        $this->video_youtube_id = $video_youtube_id;
        $this->tag_slug_id = (new Slugify())->slugify($tag_name);
        $this->tag_name = $tag_name;
        $this->user_id = $user_id;
    }
}