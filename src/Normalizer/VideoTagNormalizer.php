<?php

declare(strict_types=1);

namespace Normalizer;

final class VideoTagNormalizer
{
    //todo to complex -> make it simple
    public function normalize(array &$array): array
    {
        $last_tag_slug_id = '';

        foreach ($array as $key => &$ar) {

            if($last_tag_slug_id === $ar['tag_slug_id']){

                $array[$key -1]['video_tags'] []=
                    [
                        'start' => $ar['start'],
                        'stop' => $ar['stop'],
                        'video_tag_id' => $ar['video_tag_id']
                    ];

                unset($array[$key]);

            }else {

                $ar['video_tags'] []=
                    [
                        'start' => $ar['start'],
                        'stop' => $ar['stop'],
                        'video_tag_id' => $ar['video_tag_id']
                    ];

                unset($ar['start']);
                unset($ar['stop']);
                unset($ar['video_tag_id']);

            }

            $last_tag_slug_id = $ar['tag_slug_id'];
        }

        return array_values($array);
    }
}