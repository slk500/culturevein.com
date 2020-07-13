<?php

function video_tag_normalize(array $array)
{
    return array_values(
        array_map('join_in_video_tag_time',
            group_by_video_tag_id($array)));
}

function join_in_video_tag_time(array $a)
{
    return array_reduce($a, function (array $accumulator, array $element) {
        $accumulator['video_tag_id'] = $element['video_tag_id'];
        $accumulator['tag_name'] = $element['tag_name'];
        $accumulator['tag_slug_id'] = $element['tag_slug_id'];
        $accumulator['is_complete'] = $element['is_complete'];
        $accumulator['video_tags_time'][] =
            [
                'video_tag_time_id' => $element['video_tag_time_id'],
                'start' => $element['start'],
                'stop' => $element['stop']
            ];
        return $accumulator;
    }, []);
}

function group_by_video_tag_id(array $data)
{
    return array_reduce($data, function (array $accumulator, array $element) {
        $accumulator[$element['video_tag_id']][] = $element;
        return $accumulator;
    }, []);
}