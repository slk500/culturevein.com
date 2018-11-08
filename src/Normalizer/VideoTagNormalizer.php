<?php

declare(strict_types=1);

namespace Normalizer;

final class VideoTagNormalizer
{

    //todo to complex -> make it simple
    public function normalize(array $array): array
    {
        $previous_tag_slug_id = '';
        $previous_key_array = null;
        $result = [];

        foreach ($array as $key => $value) {

            if($previous_tag_slug_id === $value['tag_slug_id']){

                $result[$previous_key_array]['video_tags'][]=[
                    'start' => $value['start'],
                    'stop' => $value['stop'],
                    'video_tag_id' => $value['video_tag_id']
                ];

                $previous_tag_slug_id = $value['tag_slug_id'];
                $previous_key_array = $previous_key_array;
            }

            else {
                $video_tag = [
                    'video_youtube_id' => $value['video_youtube_id'],
                    'tag_name' => $value['tag_name'],
                    'tag_slug_id' => $value['tag_slug_id'],
                    'complete' => $value['complete'],
                    'video_tags' => [
                        [
                            'start' => $value['start'],
                            'stop' => $value['stop'],
                            'video_tag_id' => $value['video_tag_id']
                        ],
                    ]
                ];

                $previous_tag_slug_id = $value['tag_slug_id'];
                $previous_key_array = $key;
                $result [] = $video_tag;
            }
        }
        return array_values($result); //have to this -> angular will throw error otherwise
    }
}