<?php

declare(strict_types=1);

namespace Deleter;


use Repository\Archiver\ArchiverRepository;
use Repository\VideoTagRepository;

final class VideoTagDeleter
{
    private $video_tag_repository;

    private $archiver_repository;

    public function __construct(VideoTagRepository $video_tag_repository, ArchiverRepository $archiver_repository)
    {
        $this->video_tag_repository = $video_tag_repository;
        $this->archiver_repository = $archiver_repository;
    }

    public function delete(string $video_youtube_id, string $tag_slug_id, ?int $user_id = null)
    {
        $this->archiver_repository->archive_video_tag($video_youtube_id, $tag_slug_id, $user_id);

        $this->video_tag_repository->remove($video_youtube_id, $tag_slug_id);
    }
}

