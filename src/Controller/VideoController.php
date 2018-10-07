<?php

namespace Controller;

use Repository\VideoRepository;

class VideoController extends BaseController
{
    protected $videoRepository;

    public function __construct()
    {
        $this->videoRepository = new VideoRepository();
    }

    public function list()
    {
        $tags = $this->videoRepository->findAll();

        $this->response($tags);
    }

    public function show(string $youtubeId)
    {
        $tags = $this->videoRepository->find($youtubeId);

        $this->response(reset($tags));
    }

    public function listHighestNumberOfTags()
    {
        $tags = $this->videoRepository->withHighestNumberOfTags();

        $this->response($tags);
    }

    public function lastTen()
    {
        $tags = $this->videoRepository->lastAdded();

        $this->response($tags);
    }
}