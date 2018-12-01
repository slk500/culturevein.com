<?php

declare(strict_types=1);

namespace Deleter;


use Model\VideoTag;
use Repository\Archiver\ArchiverRepository;
use Repository\VideoTagRepository;
use Repository\VideoTagTimeRepository;

final class VideoTagTimeDeleter
{
    private $video_tag_time_repository;

    private $archiver_repository;


    public function __construct(VideoTagTimeRepository $video_tag_time_repository, ArchiverRepository $archiver_repository)
    {
        $this->video_tag_time_repository = $video_tag_time_repository;
        $this->archiver_repository = $archiver_repository;
    }

    public function delete(int $video_tag_time_id, ?int $user_id= null)
    {
        $this->archiver_repository->archive_video_tag_time($video_tag_time_id, $user_id);

        $this->video_tag_time_repository->delete($video_tag_time_id);
    }
}

