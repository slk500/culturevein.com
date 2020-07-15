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

class VideoTagTimeController extends BaseController
{
    private Container $container;

    public function __construct()
    {
        $this->container = new Container();
    }

    public function create(\stdClass $body, string $youtube_id, string $tag_slug_id)
    {
        $video = $this->container->get(VideoRepository::class)->find($youtube_id);

        if(!$video){
            return $this->response_not_found('Video: ' . $youtube_id . ' not found');
        }

        $video_tag_id = $this->container->get(VideoTagRepository::class)
            ->find($youtube_id, $tag_slug_id);

        $video_tag_create = new VideoTagTimeCreate(
            $video_tag_id,
            $body->start,
            $body->stop,
            $this->user_id
        );

        $this->container->get(VideoTagTimeRepository::class)
            ->save($video_tag_create);

        return $body;
    }

    public function delete(string $youtube_id, string $tag_slug_id, int $video_tag_time_id)
    {
        $this->container->get(VideoTagTimeDeleter::class)->delete($video_tag_time_id, $this->user_id);
    }
}