<?php

declare(strict_types=1);

namespace Normalizer;

use DTO\Database\DatabaseTagFind;
use DTO\Database\DatabaseTagVideo;

final class DatabaseTagVideoNormalizer
{
    public function normalize(DatabaseTagVideo $object)
    {
        return [
            'slug' => $object->video_slug,
            'name' => $object->video_name,
            'duration' => $object->video_duration,
            'artist' => $object->artist_name,
            'tags' => [
                [
                    'slug' => $object->tag_slug,
                    'name' => $object->tag_name,
                    'duration' => $object->tag_duration
                ]
            ]
        ];
    }

    public function sort_by_video_slug(array $videos, DatabaseTagFind $tag): array
    {
        $result = [];
        foreach ($videos as $video) {
            if($tag->slug_id === $video->tag_slug) {
                $result[$video->video_slug]['ancestors'][] = $video;
            } else{
                $result[$video->video_slug]['descendants'][] = $video;
            }

        }
        return $result;
    }
}