<?php

declare(strict_types=1);

namespace Normalizer;

use DTO\VideoTagRaw;

final class VideoTagNormalizer
{

    //todo to complex -> make it simple
    public function normalize(array $array): array
    {
        $previous_tag_slug_id = '';
        $previous_key_array = null;
        $result = [];

        /**
         * @var $video_tag VideoTagRaw
         */
        foreach ($array as $key => $video_tag) {

            if($previous_tag_slug_id === $video_tag->tag_slug_id){

                $result[$previous_key_array]['video_tags_time'][]=[
                    'video_tag_time_id' => $video_tag->video_tag_time_id,
                    'start' => $video_tag->start,
                    'stop' => $video_tag->stop
                ];

                $previous_tag_slug_id = $video_tag->tag_slug_id;
                $previous_key_array = $previous_key_array;
            }

            else {
                $video_tag_normalize = [
                    'video_tag_id' => $video_tag->video_tag_id,
                    'video_youtube_id' => $video_tag->video_youtube_id,
                    'tag_name' => $video_tag->tag_name,
                    'tag_slug_id' => $video_tag->tag_slug_id,
                    'is_complete' => $video_tag->is_complete,
                    'video_tags_time' => [
                        [
                            'video_tag_time_id' => $video_tag->video_tag_time_id,
                            'start' => $video_tag->start,
                            'stop' => $video_tag->stop
                        ],
                    ]
                ];

                $previous_tag_slug_id = $video_tag->tag_slug_id;
                $previous_key_array = $key;
                $result [] = $video_tag_normalize;
            }
        }
        return array_values($result); //have to do this -> angular will throw error otherwise
    }
}