<?php

declare(strict_types=1);

namespace Controller;

use Container;
use Controller\Base\BaseController;
use Factory\VideoFactory;
use DTO\VideoCreate;
use Repository\VideoRepository;
use Service\TokenService;

class VideoController extends BaseController
{
    private $token_service;

    private $container;

    public function __construct()
    {
        $this->container = new Container();
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

        $video_factory = $this->container->get(VideoFactory::class);

        $video_factory->create($video_create);

        return $this->response_created($video_create);
    }

    public function list()
    {
        $video_repository = $this->container->get(VideoRepository::class);

        $videos = $video_repository->find_all();

        return $this->response($videos);
    }

    public function show(string $youtube_id)
    {
        $video_repository = $this->container->get(VideoRepository::class);

        $video = $video_repository->find($youtube_id);

        return $this->response([$video]);
    }

    public function highest_number_of_tags()
    {
        $video_repository = $this->container->get(VideoRepository::class);

        $videos = $video_repository->with_highest_number_of_tags();

        return $this->response($videos);
    }

    public function newest_ten()
    {
        $video_repository = $this->container->get(VideoRepository::class);

        $videos = $video_repository->newest_ten();

        return $this->response($videos);
    }
}