<?php

declare(strict_types=1);

namespace Controller;


use Controller\Base\BaseController;
use Deleter\VideoTagDeleter;
use Repository\VideoTagRepository;

class VideoTagController extends BaseController
{
    private $video_tag_repository;

    private $video_tag_deleter;

    public function __construct()
    {
        $this->video_tag_repository = new VideoTagRepository();
        $this->video_tag_deleter = new VideoTagDeleter();
    }

    public function delete($video_tag_id)
    {
        $this->video_tag_deleter->delete((int) $video_tag_id);

        $this->response();
    }
}