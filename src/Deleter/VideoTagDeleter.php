<?php

declare(strict_types=1);

namespace Deleter;


use Model\VideoTag;
use Repository\VideoTagRepository;

class VideoTagDeleter
{
    private $video_tag_repository;

    public function __construct()
    {
        $this->video_tag_repository = new VideoTagRepository();
    }

    public function delete(int $video_tag_id, ?int $user_id)
    {
        $video_tag = $this->video_tag_repository->find($video_tag_id);
        $is_only_one = $this->video_tag_repository->is_only_one($video_tag_id);

        $this->video_tag_repository->archive($video_tag_id, $user_id);

        if($is_only_one){
            if($this->is_time_range_null($video_tag)){
                $this->video_tag_repository->delete($video_tag_id);
            }else{
                $this->video_tag_repository->set_start_and_stop_null($video_tag_id);
            }
        }else{
            //todo should check if time_range is not null for all video_tags
            $this->video_tag_repository->delete($video_tag_id);
        }
    }

    private function is_time_range_null(VideoTag $video_tag): bool
    {
        return $video_tag->start === null && $video_tag->stop === null;
    }
}

