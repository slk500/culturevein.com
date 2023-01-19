<?php

namespace Tests\Normalizer;

use PHPUnit\Framework\TestCase;

class ArtistShowNormalizerTest extends TestCase
{
    public function test_artist_show_normalize()
    {
        $input = [
            [
                'video_name' => 'Dark Horse ft. Juicy J',
                'video_youtube_id' => '0KSOMA3QBU0',
                'artist_name' => 'Katy Perry',
                'tag_name' => 'Ancient Egypt',
                'tag_slug' => 'ancient-egypt',
            ],
            [
                'video_name' => 'This Is How We do',
                'video_youtube_id' => '7RMQksXpQSk',
                'artist_name' => 'Katy Perry',
                'tag_name' => 'basketball',
                'tag_slug' => 'basketball',
            ],
            [
                'video_name' => 'This Is How We do',
                'video_youtube_id' => '7RMQksXpQSk',
                'artist_name' => 'Katy Perry',
                'tag_name' => 'table tennis (ping pong)',
                'tag_slug' => 'table-tennis-ping-pong',
            ]
        ];

        $output = artist_show_normalize($input);

        $expected =
            [
                'name' => 'Katy Perry',
                'videos' =>
                    [
                        [
                            'youtube_id' => '0KSOMA3QBU0',
                            'name' => 'Dark Horse ft. Juicy J',
                            'tags' =>
                                [
                                    [
                                        'slug' => 'ancient-egypt',
                                        'name' => 'Ancient Egypt',
                                    ],
                                ],
                        ],
                        [
                            'youtube_id' => '7RMQksXpQSk',
                            'name' => 'This Is How We do',
                            'tags' =>
                                [
                                    [
                                        'slug' => 'basketball',
                                        'name' => 'basketball',
                                    ],
                                    [
                                        'slug' => 'table-tennis-ping-pong',
                                        'name' => 'table tennis (ping pong)',
                                    ],
                                ],
                        ]
                    ],
                'tags' => [
                    [
                        'slug' => 'ancient-egypt',
                        'name' => 'Ancient Egypt',
                    ],
                    [
                        'slug' => 'basketball',
                        'name' => 'basketball',
                    ],
                    [
                        'slug' => 'table-tennis-ping-pong',
                        'name' => 'table tennis (ping pong)',
                    ]
                ]
            ];

        $this->assertSame($expected, $output);
    }

    public function test_get_tags()
    {
        $input =  [
            [
                'tags' =>
                    [
                        [
                            'slug' => 'ancient-egypt',
                            'name' => 'Ancient Egypt',
                        ],
                    ],
            ],
            [
                'tags' =>
                    [
                        [
                            'slug' => 'basketball',
                            'name' => 'basketball',
                        ],
                        [
                            'slug' => 'ancient-egypt',
                            'name' => 'Ancient Egypt',
                        ],
                        [
                            'slug' => 'table-tennis-ping-pong',
                            'name' => 'table tennis (ping pong)',
                        ],
                    ],
            ]
        ];

        $expected = [
            [
                'slug' => 'ancient-egypt',
                'name' => 'Ancient Egypt',
            ],
            [
                'slug' => 'basketball',
                'name' => 'basketball',
            ],
            [
                'slug' => 'table-tennis-ping-pong',
                'name' => 'table tennis (ping pong)',
            ],
        ];

       $output = artist_get_tags($input);

       $this->assertSame($expected, $output);
    }
}
