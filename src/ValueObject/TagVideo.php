<?php


namespace ValueObject;


use Cocur\Slugify\Slugify;
use DTO\RequestTagVideo;

class TagVideo
{
    public string $youtube_id;

    public string $tag_name;

    public string $tag_slug_id;

    public ?int $user_id;

    public function __construct(RequestTagVideo $request_tag_video)
    {
        $this->youtube_id = $request_tag_video->youtube_id;
        $this->user_id = $request_tag_video->user_id;

        $this->tag_name = trim($request_tag_video->tag_name);

        if (empty($this->tag_name)){
            throw new \Exception('Tag name is empty!');
        }

        $this->tag_slug_id = (new Slugify())->slugify($this->tag_name);
    }
}