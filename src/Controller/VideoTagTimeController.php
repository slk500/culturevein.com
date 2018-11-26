<?php

declare(strict_types=1);

namespace Controller;


use Controller\Base\BaseController;
use Deleter\VideoTagDeleter;
use DTO\VideoTagCreate;
use DTO\VideoTagTimeCreate;
use Factory\VideoTagFactory;
use Normalizer\VideoTagNormalizer;
use Repository\VideoTagRepository;
use Repository\VideoTagTimeRepository;
use Service\TokenService;

class VideoTagTimeController extends BaseController
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

    //todo what if video_tag dosent exist?
    public function create(string $youtube_id, string $tag_slug_id): void
    {
        $body = $this->get_body();

        $token = $this->get_bearer_token();
        $user_id = $this->token_service->decode_user_id($token);

        $video_tag_id = $this->video_tag_repository->find($youtube_id, $tag_slug_id);

        $video_tag_create = new VideoTagTimeCreate(
            $video_tag_id,
            $body->start,
            $body->stop,
            $user_id
        );

        $this->video_tag_time_repository->save($video_tag_create);

        $this->response_created($body);
    }

    public function delete(int $video_tag_id)
    {
        $token = $this->get_bearer_token();
        $user_id = $this->token_service->decode_user_id($token);

        $this->video_tag_deleter->delete((int) $video_tag_id, $user_id);

        $this->response();
    }
}