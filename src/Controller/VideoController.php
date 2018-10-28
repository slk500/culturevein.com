<?php

declare(strict_types=1);

namespace Controller;

use Controller\Base\BaseController;
use Factory\VideoFactory;
use DTO\VideoCreate;
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
        $video_create = new VideoCreate(
            $data->artist,
            $data->name,
            $data->youtube_id
        );

        $this->video_factory->create($video_create);

        $this->response_created($video_create);
    }

    public function list()
    {
        $videos = $this->video_repository->find_all();

        $this->response($videos);
    }

    public function show(string $youtube_id)
    {
        $video = $this->video_repository->find($youtube_id);

        $this->response($video);
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

    public function tags(string $youtube_id)
    {
        $tags = $this->tag_repository->find_by_video($youtube_id);
        (new VideoTagNormalizer())->normalize($tags);

        $this->response($tags);
    }
}