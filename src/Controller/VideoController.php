<?php

declare(strict_types=1);

namespace Controller;

use Controller\Base\BaseController;
use Factory\VideoFactory;
use DTO\VideoCreate;
use Normalizer\VideoTagNormalizer;
use Repository\TagRepository;
use Repository\VideoRepository;
use Repository\VideoTagRepository;
use Service\TokenService;

class VideoController extends BaseController
{
    private $video_repository;

    private $video_tag_repository;

    private $video_factory;

    private $token_service;

    public function __construct()
    {
        $this->video_repository = new VideoRepository();
        $this->video_tag_repository = new VideoTagRepository();
        $this->video_factory = new VideoFactory();
        $this->token_service = new TokenService();
    }

    public function create()
    {
        $data = $this->get_body();

        $token = $this->get_bearer_token();

        $user_id = $this->token_service->decode_user_id($token);

        $video_create = new VideoCreate(
            $data->artist,
            $data->name,
            $data->youtube_id,
            $user_id
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

        $this->response([$video]);
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
}