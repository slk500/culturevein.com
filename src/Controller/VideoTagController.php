<?php

declare(strict_types=1);

namespace Controller;


use Controller\Base\BaseController;
use Repository\VideoTagRepository;

class VideoTagController extends BaseController
{
    private $video_tag_repository;

    public function __construct()
    {
        $this->video_tag_repository = new VideoTagRepository();
    }

    public function delete($video_tag_id)
    {
        $this->video_tag_repository->delete((int) $video_tag_id);

        $this->response((int) $video_tag_id);
    }
}