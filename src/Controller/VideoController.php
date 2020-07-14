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
    private TokenService $token_service;

    private Container $container;

    private VideoRepository $video_repository;

    public function __construct()
    {
        $this->container = new Container();
        $this->token_service = new TokenService();
        $this->video_repository = $this->container->get(VideoRepository::class);
    }

    public function create()
    {
        $data = $this->get_body();

        $token = $this->get_bearer_token();
        $user_id = $token ? $this->token_service->decode_user_id($token) : null;

        $video_create = new VideoCreate(
            $data->artist,
            $data->name,
            $data->youtube_id,
            $data->duration,
            $user_id
        );

        $video_factory = $this->container->get(VideoFactory::class);

        $video_factory->create($video_create);

        return $video_create;
    }

    public function list()
    {
        return video_list_normalize($this->video_repository->find_all());
    }

    public function show(string $youtube_id)
    {
        return [$this->video_repository->find($youtube_id)];
    }

    public function highest_number_of_tags()
    {
        return $this->video_repository->with_highest_number_of_tags();
    }

    public function newest_ten()
    {
        return $this->video_repository->newest_ten();
    }
}