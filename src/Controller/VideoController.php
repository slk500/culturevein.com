<?php

namespace Controller;

use Repository\VideoRepository;

class VideoController extends BaseController
{
    public function list()
    {
        $videoRepo = new VideoRepository();
        $tags = $videoRepo->findAll();

        $this->response($tags);
    }

    public function show(string $youtubeId)
    {
        $videoRepo = new VideoRepository();
        $tags = $videoRepo->find($youtubeId);

        $this->response(reset($tags));
    }

    public function showTags()
    {

    }

    public function listHighestNumberOfTags()
    {
        $videoRepo = new VideoRepository();
        $tags = $videoRepo->withHighestNumberOfTags();

        $this->response($tags);
    }

    public function lastTen()
    {
        $videoRepo = new VideoRepository();
        $tags = $videoRepo->lastAdded();

        $this->response($tags);
    }
}