<?php

declare(strict_types=1);

namespace Normalizer;

use Model\VideoTag;

final class VideoTagNormalizer
{

    //todo to complex -> make it simple
    public function normalize(array $array): array
    {
        $previous_tag_slug_id = '';
        $previous_key_array = null;
        $result = [];

        /**
         * @var $video_tag VideoTag
         */
        foreach ($array as $key => $video_tag) {

            if($previous_tag_slug_id === $video_tag->tag_slug_id){

                $result[$previous_key_array]['video_tags'][]=[
                    'start' => $video_tag->start,
                    'stop' => $video_tag->stop,
                    'video_tag_id' => $video_tag->video_tag_id
                ];

                $previous_tag_slug_id = $video_tag->tag_slug_id;
                $previous_key_array = $previous_key_array;
            }

            else {
                $video_tag_normalize = [
                    'video_youtube_id' => $video_tag->video_youtube_id,
                    'tag_name' => $video_tag->tag_name,
                    'tag_slug_id' => $video_tag->tag_slug_id,
                    'complete' => $video_tag->complete,
                    'video_tags' => [
                        [
                            'start' => $video_tag->start,
                            'stop' => $video_tag->stop,
                            'video_tag_id' => $video_tag->video_tag_id
                        ],
                    ]
                ];

                $previous_tag_slug_id = $video_tag->tag_slug_id;
                $previous_key_array = $key;
                $result [] = $video_tag_normalize;
            }
        }
        return array_values($result); //have to this -> angular will throw error otherwise
    }
}