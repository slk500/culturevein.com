<?php

declare(strict_types=1);

namespace Controller;


use Container;
use Controller\Base\BaseController;
use Deleter\VideoTagTimeDeleter;
use DTO\VideoTagTimeCreate;
use Repository\VideoTagRepository;
use Repository\VideoTagTimeRepository;
use Service\TokenService;

class VideoTagTimeController extends BaseController
{
    private $token_service;

    /**
     * @var Container
     */
    private $container;

    public function __construct()
    {
        $this->token_service = new TokenService();
        $this->container = new Container();
    }

    //todo what if video_tag dosent exist?
    public function create(string $youtube_id, string $tag_slug_id): void
    {
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

        $this->response_created($body);
    }

    public function delete(string $youtube_id, string $tag_slug_id, int $video_tag_id)
    {
        $token = $this->get_bearer_token();
        $user_id = $this->token_service->decode_user_id($token);

        $this->container->get(VideoTagTimeDeleter::class)->delete($video_tag_id, $user_id);

        $this->response();
    }
}