<?php

use DTO\Database\DatabaseTagFind;
use DTO\Database\DatabaseTagVideo;

//todo refactor!
function tag_show_normalizer(array $tag_videos, DatabaseTagFind $tag): array
{
    $sortedTagVideos = sort_by_video_slug($tag_videos, $tag);

    $result = [];
    foreach ($sortedTagVideos as $tagVideo) {

        if (!array_key_exists('ancestors', $tagVideo)) $tagVideo['ancestors'] = [];
        if (!array_key_exists('descendants', $tagVideo)) $tagVideo['descendants'] = [];

        /**
         * @var DatabaseTagVideo
         */
        $first = $tagVideo['ancestors'][0] ?? $tagVideo['descendants'][0];
        //todo check if it work?
        $ancestorsTime = array_reduce($tagVideo['ancestors'], fn(int $carry, $tagVideo) => $carry + $tagVideo->tag_duration, 0);
        $descendantsTime = array_reduce($tagVideo['descendants'], fn(int $carry, $tagVideo) => $carry + $tagVideo->tag_duration, 0);
        $totalTime = $ancestorsTime + $descendantsTime;

        $totalTimeTag = ($totalTime > $first->video_duration) ? $first->video_duration : $totalTime;
        $totalTimeTag = ($totalTimeTag === 0) ? null : $totalTimeTag;

        $descendants = array_map(fn(DatabaseTagVideo $databaseTagVideo) => [
            'slug' => $databaseTagVideo->tag_slug,
            'name' => $databaseTagVideo->tag_name,
            'duration' => $databaseTagVideo->tag_duration
        ]
            , $tagVideo['descendants']);

        $result [] = [
            'slug' => $first->video_slug,
            'name' => $first->video_name,
            'duration' => $first->video_duration,
            'artist' => $first->artist_name,
            'tags' => [
                [
                    'slug' => $tag->slug_id,
                    'name' => $tag->name,
                    'duration' => $totalTimeTag,
                    'tags' => $descendants
                ]
            ]
        ];
    }

    usort($result, function ($a, $b) {
        return $b['tags'][0]['duration'] <=> $a['tags'][0]['duration'];
    });
    return $result;
}

function normalize(DatabaseTagVideo $object)
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

function sort_by_video_slug(array $videos, DatabaseTagFind $tag): array
{
    $result = [];
    foreach ($videos as $video) {
        if ($tag->slug_id === $video->tag_slug) {
            $result[$video->video_slug]['ancestors'][] = $video;
        } else {
            $result[$video->video_slug]['descendants'][] = $video;
        }

    }
    return $result;
}