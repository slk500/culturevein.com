<?php

declare(strict_types=1);

use Normalizer\VideoTagNormalizer;
use PHPUnit\Framework\TestCase;

class VideoTagNormalizerTest extends TestCase
{
    /**
     * @var VideoTagNormalizer
     */
    private $video_tag_normalizer;

    public function setUp()
    {
        $this->video_tag_normalizer = new VideoTagNormalizer();
    }

    /**
     * @test
     */
    public function normalize_one_video_tag()
    {
        $input = [
            [
                'video_tag_id' => 10,
                'video_youtube_id' => 'HcXNPI-IPPM',
                "tag_name" => "BMW",
                "start" => 0,
                "stop" => 20,
                "tag_slug_id" => "bmw",
                "complete" => 1
            ]
        ];

        $output = $this->video_tag_normalizer->normalize($input);

        $expectedOutput = [
            [
                'video_youtube_id' => 'HcXNPI-IPPM',
                'tag_name' => 'BMW',
                'tag_slug_id' => 'bmw',
                'complete' => 1,
                'video_tags' => [
                    [
                        'start' => 0,
                        'stop' => 20,
                        'video_tag_id' => 10
                    ],
                ]
            ]
        ];
        $this->assertSame($expectedOutput, $output);
    }

    /**
     * @test
     */
    public function normalize_two_video_tag()
    {
        $input = [
            [
                'video_tag_id' => 10,
                'video_youtube_id' => 'HcXNPI-IPPM',
                "tag_name" => "BMW",
                "start" => 0,
                "stop" => 20,
                "tag_slug_id" => "bmw",
                "complete" => 1
            ],
            [
                'video_tag_id' => 20,
                'video_youtube_id' => 'HcXNPI-IPPM',
                "tag_name" => "BMW",
                "start" => 20,
                "stop" => 40,
                "tag_slug_id" => "bmw",
                "complete" => 1
            ],
        ];

        $output = $this->video_tag_normalizer->normalize($input);

        $expectedOutput = [
            [
                'video_youtube_id' => 'HcXNPI-IPPM',
                'tag_name' => 'BMW',
                'tag_slug_id' => 'bmw',
                'complete' => 1,
                'video_tags' => [
                    [
                        'start' => 0,
                        'stop' => 20,
                        'video_tag_id' => 10
                    ],
                    [
                        'start' => 20,
                        'stop' => 40,
                        'video_tag_id' => 20
                    ],
                ]
            ]
        ];
        $this->assertSame($expectedOutput, $output);
    }

    /**
     * @test
     */
    public function normalize_three_video_tag()
    {
        $input = [
            [
                'video_tag_id' => 10,
                'video_youtube_id' => 'HcXNPI-IPPM',
                "tag_name" => "BMW",
                "start" => 0,
                "stop" => 20,
                "tag_slug_id" => "bmw",
                "complete" => 1
            ],
            [
                'video_tag_id' => 20,
                'video_youtube_id' => 'HcXNPI-IPPM',
                "tag_name" => "BMW",
                "start" => 20,
                "stop" => 40,
                "tag_slug_id" => "bmw",
                "complete" => 1
            ],
            [
                'video_tag_id' => 30,
                'video_youtube_id' => 'HcXNPI-IPPM',
                "tag_name" => "BMW",
                "start" => 40,
                "stop" => 60,
                "tag_slug_id" => "bmw",
                "complete" => 1
            ],
        ];

        $output = $this->video_tag_normalizer->normalize($input);

        $expectedOutput = [
            [
                'video_youtube_id' => 'HcXNPI-IPPM',
                'tag_name' => 'BMW',
                'tag_slug_id' => 'bmw',
                'complete' => 1,
                'video_tags' => [
                    [
                        'start' => 0,
                        'stop' => 20,
                        'video_tag_id' => 10
                    ],
                    [
                        'start' => 20,
                        'stop' => 40,
                        'video_tag_id' => 20
                    ],
                    [
                        'start' => 40,
                        'stop' => 60,
                        'video_tag_id' => 30
                    ],
                ]
            ]
        ];
        $this->assertSame($expectedOutput, $output);
    }


    /**
     * @test
     */
    public function normallize_two_same_one_diffrent_video_tag()
    {
        $input = [
            [
                'video_tag_id' => 10,
                'video_youtube_id' => 'HcXNPI-IPPM',
                "tag_name" => "BMW",
                "start" => 0,
                "stop" => 20,
                "tag_slug_id" => "bmw",
                "complete" => 1
            ],
            [
                'video_tag_id' => 20,
                'video_youtube_id' => 'HcXNPI-IPPM',
                "tag_name" => "BMW",
                "start" => 40,
                "stop" => 60,
                "tag_slug_id" => "bmw",
                "complete" => 1
            ],
            [
                'video_tag_id' => 30,
                'video_youtube_id' => 'HcXNPI-IPPM',
                "tag_name" => "Subaru",
                "start" => 100,
                "stop" => 120,
                "tag_slug_id" => "subaru",
                "complete" => 0
            ]
        ];

        $expectedResult = [
            [
                'video_youtube_id' => 'HcXNPI-IPPM',
                'tag_name' => 'BMW',
                'tag_slug_id' => 'bmw',
                'complete' => 1,
                'video_tags' => [
                    [
                        'start' => 0,
                        'stop' => 20,
                        'video_tag_id' => 10
                    ],
                    [
                        'start' => 40,
                        'stop' => 60,
                        'video_tag_id' => 20
                    ]
                ]
            ],
            [
                'video_youtube_id' => 'HcXNPI-IPPM',
                'tag_name' => 'Subaru',
                'tag_slug_id' => 'subaru',
                'complete' => 0,
                'video_tags' => [
                    [
                        'start' => 100,
                        'stop' => 120,
                        'video_tag_id' => 30
                    ]
                ]
            ],
        ];

        $normalizer = new VideoTagNormalizer();
        $output = $normalizer->normalize($input);

        $this->assertSame($expectedResult, $output);
    }
}
