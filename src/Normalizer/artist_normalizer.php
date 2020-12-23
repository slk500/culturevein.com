<?php

function artist_list_normalize(array $videos): array
{
    return array_map('reduce_to_videos',
        group_by($videos, 'artist_slug'));
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

function reduce_to_videos_with_tags(array $a): array
{
    return array_reduce($a, function (array $accumulator, array $element) {
        $accumulator['youtube_id'] = $element['video_youtube_id'];
        $accumulator['name'] = $element['video_name'];

        if($element['tag_slug'] != null) {
            $accumulator['tags'][] =
                [
                    'slug' => $element['tag_slug'],
                    'name' => $element['tag_name']
                ];
        }else{
            $accumulator['tags'] = [];
        }

        return $accumulator;
    }, []);
}

function artist_show_normalize(array $videos): array
{
    $result = [];

    $result['name'] = reset($videos)['artist_name'];
    $result['videos'] = array_map('reduce_to_videos_with_tags',
        group_by($videos, 'video_youtube_id'));
    $result['tags'] = artist_get_tags($result['videos']);

    return $result;
}

function artist_get_tags(array $videos): array
{
    $tags = array_map(fn(array $array) => $array['tags'], $videos);
    $merged = array_merge(...$tags);
    $unique = array_unique($merged, SORT_REGULAR);
    $result = array_values($unique);

    usort($result, function ($item1, $item2) {
        return $item1['slug'] <=> $item2['slug'];
    });
    
    return $result;
}