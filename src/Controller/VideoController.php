<?php

namespace Controller;

use Repository\VideoRepository;

class VideoController extends BaseController
{
    public function listAction()
    {
        $videoRepo = new VideoRepository();
        $tags = $videoRepo->findAll();

        $this->response($tags);
    }

    public function showAction(string $youtubeId)
    {
        $videoRepo = new VideoRepository();
        $tags = $videoRepo->find($youtubeId);

        $this->response(reset($tags));
    }

    public function showTagsAction()
    {

    }

    public function listHighestNumberOfTags()
    {
        $videoRepo = new VideoRepository();
        $tags = $videoRepo->withHighestNumberOfTags();

        $this->response($tags);
    }

    public function lastTenAction()
    {
        $videoRepo = new VideoRepository();
        $tags = $videoRepo->lastAdded();

        $this->response($tags);
    }
}