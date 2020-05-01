<?php

namespace Normalizer;

function video_list_normalize(array $videos): array
{
    $result = [];

    foreach ($videos as $video) {
        $slug = $video['artist_slug'];

        $result[$slug]['name'] = $video['artist_name'];
        $result[$slug]['slug'] = $slug;

        $result[$slug]['videos'][] = [
            'name' => $video['video_name'],
            'youtube_id' => $video['video_youtube_id']
        ];
    }

    return array_values($result);
}