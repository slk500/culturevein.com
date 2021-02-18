<?php

declare(strict_types=1);

namespace Deleter;

use Database\Archiver\ArchiverRepository;
use Database\TagVideoCommand;

final class VideoTagDeleter
{
    private $archiver_repository;

    private TagVideoCommand $tag_video_command;

    public function __construct(TagVideoCommand $tag_video_command, ArchiverRepository $archiver_repository)
    {
        $this->archiver_repository = $archiver_repository;
        $this->tag_video_command = $tag_video_command;
    }

    public function delete(string $video_youtube_id, string $tag_slug_id, int $user_id)
    {
        $this->archiver_repository->archive_video_tag($video_youtube_id, $tag_slug_id, $user_id);

        $this->tag_video_command->remove($video_youtube_id, $tag_slug_id);
    }
}

