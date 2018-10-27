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

        http_response_code(201);
    }

    public function list()
    {
        $videos = $this->video_repository->find_all();

        $this->response($videos);
    }

    public function show(string $youtubeId)
    {
        $video = $this->video_repository->find($youtubeId);

        $this->response(reset($video));
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