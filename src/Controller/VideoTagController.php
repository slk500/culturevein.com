<?php

declare(strict_types=1);

namespace Controller;


use Controller\Base\BaseController;
use Deleter\VideoTagDeleter;
use Repository\VideoTagRepository;
use Service\TokenService;

class VideoTagController extends BaseController
{
    private $video_tag_repository;

    private $video_tag_deleter;

    private $token_service;

    public function __construct()
    {
        $this->video_tag_repository = new VideoTagRepository();
        $this->video_tag_deleter = new VideoTagDeleter();
        $this->token_service = new TokenService();
    }

    public function delete($video_tag_id)
    {
        $token = $this->getBearerToken();

        $user_id = null;
        if($token){
            $user_id = $this->token_service->decode_user_id($token);
        }

        $this->video_tag_deleter->delete((int) $video_tag_id, $user_id);

        $this->response();
    }
}