<?php

declare(strict_types=1);

use Normalizer\VideoTagNormalizer;
use PHPUnit\Framework\TestCase;
use Tests\Builder\VideoTag\VideoTagRawBuilder;

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
        $video_tag_raw = (new VideoTagRawBuilder())->build();

        $output = $this->video_tag_normalizer->normalize([$video_tag_raw]);

        $expectedOutput = [
            [   'video_tag_id' => 1,
                'video_youtube_id' => 'HcXNPI-IPPM',
                'tag_name' => 'video game',
                'tag_slug_id' => 'video-game',
                'is_complete' => true,
                'video_tags_time' => [
                    [
                        'video_tag_time_id' => 1,
                        'start' => 0,
                        'stop' => 10,
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
        $video_tag1 = (new VideoTagRawBuilder())->build();

        $video_tag2 = (new VideoTagRawBuilder())
            ->video_tag_time_id(2)
            ->start(10)
            ->stop(20)
            ->build();

        $input = [$video_tag1, $video_tag2];

        $output = $this->video_tag_normalizer->normalize($input);

        $expectedOutput = [
            [
                'video_tag_id' => 1,
                'video_youtube_id' => 'HcXNPI-IPPM',
                'tag_name' => 'video game',
                'tag_slug_id' => 'video-game',
                'is_complete' => true,
                'video_tags_time' => [
                    [
                        'video_tag_time_id' => 1,
                        'start' => 0,
                        'stop' => 10,
                    ],
                    [
                        'video_tag_time_id' => 2,
                        'start' => 10,
                        'stop' => 20
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
        $video_tag1 = (new VideoTagRawBuilder())->build();

        $video_tag2 = (new VideoTagRawBuilder())
            ->video_tag_time_id(2)
            ->start(10)
            ->stop(20)
            ->build();

        $video_tag3 = (new VideoTagRawBuilder())
            ->video_tag_time_id(3)
            ->start(20)
            ->stop(30)
            ->build();

        $input = [$video_tag1, $video_tag2, $video_tag3];

        $output = $this->video_tag_normalizer->normalize($input);

        $expectedOutput = [
            [
                'video_tag_id' => 1,
                'video_youtube_id' => 'HcXNPI-IPPM',
                'tag_name' => 'video game',
                'tag_slug_id' => 'video-game',
                'is_complete' => true,
                'video_tags_time' => [
                    [
                        'video_tag_time_id' => 1,
                        'start' => 0,
                        'stop' => 10,
                    ],
                    [
                        'video_tag_time_id' => 2,
                        'start' => 10,
                        'stop' => 20
                    ],
                    [
                        'video_tag_time_id' => 3,
                        'start' => 20,
                        'stop' => 30
                    ],
                ]
            ]
        ];
        $this->assertSame($expectedOutput, $output);
    }


    /**
     * @test
     */
    public function normalize_two_same_one_different_video_tag()
    {
        $video_tag1 = (new VideoTagRawBuilder())->build();

        $video_tag2 = (new VideoTagRawBuilder())
            ->video_tag_time_id(2)
            ->start(10)
            ->stop(20)
            ->build();


        $video_tag1 = (new VideoTagRawBuilder())->build();

        $video_tag3 = (new VideoTagRawBuilder())
            ->video_tag_id(2)
            ->video_tag_time_id(1)
            ->tag_name('Subaru')
            ->start(0)
            ->stop(10)
            ->build();


        $input = [$video_tag1, $video_tag2, $video_tag3];

        $expectedResult = [
            [
                'video_tag_id' => 1,
                'video_youtube_id' => 'HcXNPI-IPPM',
                'tag_name' => 'video game',
                'tag_slug_id' => 'video-game',
                'is_complete' => true,
                'video_tags_time' => [
                    [
                        'video_tag_time_id' => 1,
                        'start' => 0,
                        'stop' => 10,
                    ],
                    [
                        'video_tag_time_id' => 2,
                        'start' => 10,
                        'stop' => 20
                    ],
                ]
            ],
            [
                'video_tag_id' => 2,
                'video_youtube_id' => 'HcXNPI-IPPM',
                'tag_name' => 'Subaru',
                'tag_slug_id' => 'subaru',
                'is_complete' => true,
                'video_tags_time' => [
                    [
                        'video_tag_time_id' => 1,
                        'start' => 0,
                        'stop' => 10,
                    ]
                ]
            ],
        ];

        $normalizer = new VideoTagNormalizer();
        $output = $normalizer->normalize($input);

        $this->assertSame($expectedResult, $output);
    }
}
