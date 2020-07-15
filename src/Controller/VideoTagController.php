<?php

declare(strict_types=1);

namespace Controller;

use Container;
use Controller\Base\BaseController;
use Deleter\VideoTagDeleter;
use DTO\VideoTagCreate;
use Factory\VideoTagFactory;
use Repository\VideoTagRepository;
use Service\TokenService;

class VideoTagController extends BaseController
{
    private Container $container;

    public function __construct()
    {
        $this->container = new Container();
    }

    //todo what if tag dosent exist?
    public function create(\stdClass $data, string $youtube_id)
    {
        $video_tag_create = new VideoTagCreate(
            $youtube_id,
            $data->tag_name,
            $this->user_id
        );

        $video_tag_factory = $this->container->get(VideoTagFactory::class);
        $video_tag_factory->create($video_tag_create);

        return $video_tag_create;
    }

    public function list()
    {
        $video_tag_repository = $this->container->get(VideoTagRepository::class);
        return $video_tag_repository->find_all();
    }

    public function list_for_video(string $youtube_id)
    {
        $video_tag_repository = $this->container->get(VideoTagRepository::class);
        $tags = $video_tag_repository->find_all_for_video($youtube_id);
        return video_tag_normalize($tags);
    }

    public function delete(string $video_youtube_id, string $tag_slug_id)
    {
        $video_tag_deleter = $this->container->get(VideoTagDeleter::class);
        $video_tag_deleter->delete($video_youtube_id, $tag_slug_id, $this->user_id);
    }

    public function update(\stdClass $data, string $video_youtube_id, string $tag_slug_id)
    {
        $video_tag_repository = $this->container->get(VideoTagRepository::class);
        $video_tag_repository->set_is_complete($video_youtube_id, $tag_slug_id, $data->is_complete);
    }
}
