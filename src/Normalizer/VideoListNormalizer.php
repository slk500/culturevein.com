<?php

namespace Normalizer;

function video_list_normalize(array $videos): array
{
    $result = [];
    $last_artist_slug = null;
    foreach ($videos as $video) {

        if (($video['artist_slug']) === $last_artist_slug) {
            $result[array_key_last($result)]['videos'][] =
                [
                    'name' => $video['video_name'],
                    'youtube_id' => $video['video_youtube_id']
                ];
        } else {
            $result [] =
                [
                'name' => $video['artist_name'],
                'slug' => $video['artist_slug'],
                'videos' => [
                    [
                        'name' => $video['video_name'],
                        'youtube_id' => $video['video_youtube_id']
                    ]
                ]
            ];
        }

        $last_artist_slug = $video['artist_slug'];
    }

    return array_values($result);
}