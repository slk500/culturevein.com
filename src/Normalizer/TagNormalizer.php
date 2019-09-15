<?php

declare(strict_types=1);

namespace Normalizer;

final class TagNormalizer
{
    public function normalize(array $array): array
    {
        if(empty($array)) return ['data' => []];

        $result = [
            'data' => [
                'id' => $array[0]['tag_slug_id'],
                'name' => $array[0]['name'],
                'subscribers' => $array[0]['subscribers'],
                'videos' => []
            ]
        ];

        if($array[0]['video_youtube_id']) {
            foreach ($array as $ar) {
                $result['data']['videos'] [] = [
                    'youtube_id' => $ar['video_youtube_id'],
                    'artist' => [
                        'name' => $ar['artist_name']
                    ],
                    'name' => $ar['video_name'],
                    'expose' => $ar['expose']
                ];
            }
        }

        return $result;
    }
}