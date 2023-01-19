<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class VideoTagNormalizerTest extends TestCase
{
    public function test_group_by_video_tag_id()
    {
        $input = [
            [
                'video_tag_id' => 1,
                'tag_name' => 'video game',
                'tag_slug_id' => 'video-game',
                'is_complete' => true,
                'video_tag_time_id' => 1,
                'start' => 1,
                'stop' => 2,
            ],
            [
                'video_tag_id' => 1,
                'tag_name' => 'video game',
                'tag_slug_id' => 'video-game',
                'is_complete' => true,
                'video_tag_time_id' => 2,
                'start' => 3,
                'stop' => 4,
            ]
        ];

        $expectedOutput = [
            [
                [
                    'video_tag_id' => 1,
                    'tag_name' => 'video game',
                    'tag_slug_id' => 'video-game',
                    'is_complete' => true,
                    'video_tag_time_id' => 1,
                    'start' => 1,
                    'stop' => 2,
                ],
                [
                    'video_tag_id' => 1,
                    'tag_name' => 'video game',
                    'tag_slug_id' => 'video-game',
                    'is_complete' => true,
                    'video_tag_time_id' => 2,
                    'start' => 3,
                    'stop' => 4,
                ]
            ]
        ];

        $output = group_by($input, 'video_tag_id');

        $this->assertSame($expectedOutput, $output);
    }

    public function test_join_in_video_tag_time()
    {
        $input = [
                [
                    'video_tag_id' => 1,
                    'tag_name' => 'video game',
                    'tag_slug_id' => 'video-game',
                    'is_complete' => true,
                    'video_tag_time_id' => 1,
                    'start' => 1,
                    'stop' => 2,
                ],
                [
                    'video_tag_id' => 1,
                    'tag_name' => 'video game',
                    'tag_slug_id' => 'video-game',
                    'is_complete' => true,
                    'video_tag_time_id' => 2,
                    'start' => 3,
                    'stop' => 4,
                ]
        ];

        $output = reduce_to_tags_with_tag_time($input);

        $expectedOutput =
            [
                'video_tag_id' => 1,
                'tag_name' => 'video game',
                'tag_slug_id' => 'video-game',
                'is_complete' => true,
                'video_tags_time' => [
                    [
                        'video_tag_time_id' => 1,
                        'start' => 1,
                        'stop' => 2,
                    ],
                    [
                        'video_tag_time_id' => 2,
                        'start' => 3,
                        'stop' => 4
                    ],
                ]
            ];

        $this->assertSame($expectedOutput, $output);
    }
}
