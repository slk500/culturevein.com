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
    private $video_repository;

    private $tag_repository;

    private $video_factory;

    public function __construct()
    {
        $this->video_repository = new VideoRepository();
        $this->tag_repository = new TagRepository();
        $this->video_factory = new VideoFactory();
    }

    public function create(object $data)
    {
        $data = $this->video_factory->create($data);

        $this->response_created($data);
    }

    public function list()
    {
        $videos = $this->video_repository->find_all();

        $this->response($videos);
    }

    public function show(string $youtubeId)
    {
        $tags = $this->video_repository->find($youtubeId);

        $this->response(reset($tags));
    }

    public function highest_number_of_tags()
    {
        $videos = $this->video_repository->with_highest_number_of_tags();

        $this->response($videos);
    }

    public function newest_ten()
    {
        $videos = $this->video_repository->newest_ten();

        $this->response($videos);
    }

    public function tags(string $youtubeId)
    {
        $tags = $this->tag_repository->find_by_video($youtubeId);
        (new VideoTagNormalizer())->normalize($tags);

        $this->response($tags);
    }
}