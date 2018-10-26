<?php

declare(strict_types=1);

namespace Controller;

use Controller\Base\BaseController;
use Factory\VideoFactory;
use Normalizer\VideoTagNormalizer;
use Repository\TagRepository;
use Repository\VideoRepository;

class VideoController extends BaseController
{
    private $videoRepository;

    private $tagRepository;

    private $videoFactory;

    public function __construct()
    {
        $this->videoRepository = new VideoRepository();
        $this->tagRepository = new TagRepository();
        $this->videoFactory = new VideoFactory();
    }

    public function create(object $data)
    {
        $data =$this->videoFactory->create($data);

        $this->responseCreated($data);
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

    public function highestNumberOfTags()
    {
        $videos = $this->videoRepository->withHighestNumberOfTags();

        $this->response($videos);
    }

    public function newestTen()
    {
        $videos = $this->videoRepository->newestTen();

        $this->response($videos);
    }

    public function tags(string $youtubeId)
    {
        $tags = $this->tagRepository->findByVideo($youtubeId);
        $tags = (new VideoTagNormalizer())->normalize($tags);

        $this->response($tags);
    }
}