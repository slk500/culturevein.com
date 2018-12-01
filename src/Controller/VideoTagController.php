<?php

declare(strict_types=1);

namespace Controller;


use Container;
use Controller\Base\BaseController;
use Deleter\VideoTagDeleter;
use DTO\VideoTagCreate;
use Factory\VideoTagFactory;
use Normalizer\VideoTagNormalizer;
use Repository\VideoTagRepository;
use Service\TokenService;

class VideoTagController extends BaseController
{
    private $token_service;

    /**
     * @var Container
     */
    private $container;

    public function __construct()
    {
        $this->container = new Container();
        $this->token_service = new TokenService();
    }

    //todo what if tag dosent exist?
    public function create(string $youtube_id): void
    {
        $body = $this->get_body();

        $token = $this->get_bearer_token();
        $user_id = $this->token_service->decode_user_id($token);

        $video_tag_create = new VideoTagCreate(
            $youtube_id,
            $body->tag_name,
            $user_id
        );

        $video_tag_factory = $this->container->get(VideoTagFactory::class);
        $video_tag_factory->create($video_tag_create);

        $this->response_created();
    }

    public function list(string $youtube_id)
    {
        $video_tag_repository = $this->container->get(VideoTagRepository::class);
        $tags = $video_tag_repository->find_all_for_video($youtube_id);
        $tags = (new VideoTagNormalizer())->normalize($tags);

        $this->response($tags);
    }

    public function delete(string $video_youtube_id, string $tag_slug_id)
    {
        $token = $this->get_bearer_token();
        $user_id = $this->token_service->decode_user_id($token);

        $video_tag_deleter = $this->container->get(VideoTagDeleter::class);

        $video_tag_deleter->delete($video_youtube_id, $tag_slug_id, $user_id);

        $this->response();
    }
}