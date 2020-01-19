<?php

declare(strict_types=1);

namespace Controller;


use Container;
use Controller\Base\BaseController;
use Deleter\VideoTagTimeDeleter;
use DTO\VideoTagTimeCreate;
use Repository\VideoRepository;
use Repository\VideoTagRepository;
use Repository\VideoTagTimeRepository;
use Service\TokenService;

class VideoTagTimeController extends BaseController
{
    private TokenService $token_service;

    private Container $container;

    public function __construct()
    {
        $this->token_service = new TokenService();
        $this->container = new Container();
    }

    public function create(string $youtube_id, string $tag_slug_id)
    {
        $video = $this->container->get(VideoRepository::class)->find($youtube_id);

        if(!$video){
            return $this->response_not_found('Video: ' . $youtube_id . ' not found');
        }

        $body = $this->get_body();

        $token = $this->get_bearer_token();
        $user_id = $this->token_service->decode_user_id($token);

        $video_tag_id = $this->container->get(VideoTagRepository::class)
            ->find($youtube_id, $tag_slug_id);

        $video_tag_create = new VideoTagTimeCreate(
            $video_tag_id,
            $body->start,
            $body->stop,
            $user_id
        );

        $this->container->get(VideoTagTimeRepository::class)
            ->save($video_tag_create);

        return $body;
    }

    public function delete(string $youtube_id, string $tag_slug_id, int $video_tag_time_id)
    {
        $token = $this->get_bearer_token();
        $user_id = $this->token_service->decode_user_id($token);

        $this->container->get(VideoTagTimeDeleter::class)->delete($video_tag_time_id, $user_id);
    }
}