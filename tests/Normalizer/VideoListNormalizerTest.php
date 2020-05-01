<?php

namespace Tests\Normalizer;


use PHPUnit\Framework\TestCase;
use function Normalizer\video_list_normalize;

class VideoListNormalizerTest extends TestCase
{
    public function testNormalize()
    {
        $input = [
            [
                'artist_name' => 'Madonna',
                'artist_slug' => 'madonna',
                'video_name' => 'Like A Prayer',
                'video_youtube_id' => '79fzeNUqQbQ'
            ],
            [
                'artist_name' => 'Madonna',
                'artist_slug' => 'madonna',
                'video_name' => 'The Power Of Good-Bye',
                'video_youtube_id' => 'NHydngA5C4E'
            ],
            [
                'artist_name' => 'Bob Marley',
                'artist_slug' => 'bob-marley',
                'video_name' => 'Is This Love',
                'video_youtube_id' => '69RdQFDuYPI'
            ],
        ];

        $result = video_list_normalize($input);

        $expected = [
            [
                'name' => 'Madonna',
                'slug' => 'madonna',
                'videos' => [
                    [
                        'name' => 'Like A Prayer',
                        'youtube_id' => '79fzeNUqQbQ'
                    ],
                    [
                        'name' => 'The Power Of Good-Bye',
                        'youtube_id' => 'NHydngA5C4E',
                    ]
                ]
            ],
            [
                'name' => 'Bob Marley',
                'slug' => 'bob-marley',
                'videos' => [
                    [
                        'name' => 'Is This Love',
                        'youtube_id' => '69RdQFDuYPI',
                    ]
                ]
            ],
        ];

        $this->assertEquals($expected, $result);
    }
}
