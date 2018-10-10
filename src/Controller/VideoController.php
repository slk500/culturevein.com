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
        $videos = $this->videoRepository->findAll();

        $this->response($videos);
    }

    public function show(string $youtubeId)
    {
        $tags = $this->videoRepository->find($youtubeId);

        $this->response(reset($tags));
    }

    public function listHighestNumberOfTags()
    {
        $videos = $this->videoRepository->withHighestNumberOfTags();

        $this->response($videos);
    }

    public function lastTen()
    {
        $videos = $this->videoRepository->lastAdded();

        $this->response($videos);
    }
}