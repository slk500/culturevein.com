<?php

declare(strict_types=1);

namespace Deleter;

use Database\Archiver\ArchiverRepository;
use Database\TagVideoTimeRepository;

final class VideoTagTimeDeleter
{
    private $video_tag_time_repository;

    private $archiver_repository;

    public function __construct(TagVideoTimeRepository $video_tag_time_repository, ArchiverRepository $archiver_repository)
    {
        $this->video_tag_time_repository = $video_tag_time_repository;
        $this->archiver_repository = $archiver_repository;
    }

    public function delete(int $video_tag_time_id, int $user_id)
    {
        $this->archiver_repository->archive_video_tag_time($video_tag_time_id, $user_id);

        $this->video_tag_time_repository->remove($video_tag_time_id);

        //todo delete video_tag if deleted video_tag_time was last in DB
    }
}
