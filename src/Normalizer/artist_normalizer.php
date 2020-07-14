<?php

function artist_list_normalize(array $videos): array
{
    $groupedBy = group_by($videos, 'artist_slug');
    return array_values(
        array_map('reduce_to_videos', $groupedBy));
}

function reduce_to_videos(array $a): array
{
    return array_reduce($a, function (array $accumulator, array $element) {
        $accumulator['name'] = $element['artist_name'];
        $accumulator['slug'] = $element['artist_slug'];
        $accumulator['videos'][] =
            [
                'name' => $element['video_name'],
                'youtube_id' => $element['video_youtube_id']
            ];
        return $accumulator;
    }, []);
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