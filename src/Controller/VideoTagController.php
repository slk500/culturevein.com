<?php

declare(strict_types=1);

namespace Controller;


use Controller\Base\BaseController;
use Deleter\VideoTagDeleter;
use DTO\VideoTagCreate;
use Factory\VideoTagFactory;
use Normalizer\VideoTagNormalizer;
use Repository\VideoTagRepository;
use Repository\VideoTagTimeRepository;
use Service\TokenService;

class VideoTagController extends BaseController
{
    private $video_tag_repository;

    private $video_tag_deleter;

    private $video_tag_factory;

    private $token_service;

    private $video_tag_time_repository;

    public function __construct()
    {
        $this->token_service = new TokenService();
        $this->video_tag_deleter = new VideoTagDeleter();
        $this->video_tag_factory = new VideoTagFactory();
        $this->video_tag_repository = new VideoTagRepository();
        $this->video_tag_time_repository = new VideoTagTimeRepository();
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

        $this->video_tag_factory->create($video_tag_create);

        $this->response_created();
    }

    public function list(string $youtube_id)
    {
        $tags = $this->video_tag_repository->find_all_for_video($youtube_id);
        $tags = (new VideoTagNormalizer())->normalize($tags);

        $this->response($tags);
    }

    public function delete(string $video_youtube_id, string $tag_slug_id)
    {
        $token = $this->get_bearer_token();
        $user_id = $this->token_service->decode_user_id($token);

        $this->video_tag_deleter->delete($video_youtube_id, $tag_slug_id, $user_id);

        $this->response();
    }
}