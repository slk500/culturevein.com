<?php

namespace Normalizer;

function video_list_normalize(array $videos): array
{
    $result = [];

    foreach ($videos as $video) {
        $slug = $video['artist_slug'];

        //overwriting!
        $result[$slug]['name'] = $video['artist_name'];
        $result[$slug]['slug'] = $slug;

        $result[$slug]['videos'][] = [
            'name' => $video['video_name'],
            'youtube_id' => $video['video_youtube_id']
        ];
    }

    return array_values($result);
}

function artist_show_normalize(array $videos): array
{
    $result = [];
    $tags_in_videos = [];
    $tags = [];

    foreach ($videos as $video) {
        $youtube_id = $video['video_youtube_id'];

        $result['name'] = $video['artist_name'];
        $result['videos'][$youtube_id] = [
            'youtube_id' => $youtube_id,
            'name' => $video['video_name'],
            'duration' => $video['duration']
        ];

        $slug = $video['tag_slug'];
        $name = $video['tag_name'];
        ($slug && $name) ?
            $tags_in_videos[$youtube_id][] = [
                'slug' => $slug,
                'name' => $name,
            ] : $tags_in_videos[$youtube_id][] = [];


        $tags[$slug] = $name;
    }

    foreach ($tags as $slug => $name) {
        $result['tags'][] = [
            'slug' => $slug,
            'name' => $name,
        ];
    }

    foreach ($tags_in_videos as $youtube_id => $tag) {
        $result['videos'][$youtube_id]['tags'] = $tag;
    }

    $result['videos'] = array_values($result['videos']);

    usort($result['tags'], function ($a, $b) {
        return $a['slug'] <=> $b['slug'];
    });

    return $result;
}