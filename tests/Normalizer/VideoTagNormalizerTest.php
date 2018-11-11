<?php

declare(strict_types=1);

use Model\VideoTag;
use Normalizer\VideoTagNormalizer;
use PHPUnit\Framework\TestCase;
use Tests\Builder\VideoTagBuilder;

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
        $video_tag = (new VideoTagBuilder())->build();

        $output = $this->video_tag_normalizer->normalize([$video_tag]);

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
        $video_tag1 = (new VideoTagBuilder())->build();

        $video_tag2 = (new VideoTagBuilder())
            ->video_tag_id(20)
            ->start(20)
            ->stop(40)
            ->build();

        $input = [$video_tag1, $video_tag2];

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
        $video_tag1 = (new VideoTagBuilder())->build();

        $video_tag2 = (new VideoTagBuilder())
            ->video_tag_id(20)
            ->start(20)
            ->stop(40)
            ->build();

        $video_tag3 = (new VideoTagBuilder())
            ->video_tag_id(30)
            ->start(40)
            ->stop(60)
            ->build();

        $input = [$video_tag1, $video_tag2, $video_tag3];

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
    public function normalize_two_same_one_different_video_tag()
    {
        $video_tag1 = new VideoTag();
        $video_tag1->video_tag_id = 10;
        $video_tag1->video_youtube_id = 'HcXNPI-IPPM';
        $video_tag1->tag_name = "BMW";
        $video_tag1->start = 0;
        $video_tag1->stop = 20;
        $video_tag1->tag_slug_id = 'bmw';
        $video_tag1->complete = 1;

        $video_tag2 = new VideoTag();
        $video_tag2->video_tag_id = 20;
        $video_tag2->video_youtube_id = 'HcXNPI-IPPM';
        $video_tag2->tag_name = "BMW";
        $video_tag2->start = 20;
        $video_tag2->stop = 40;
        $video_tag2->tag_slug_id = 'bmw';
        $video_tag2->complete = 1;

        $video_tag3 = new VideoTag();
        $video_tag3->video_tag_id = 30;
        $video_tag3->video_youtube_id = 'HcXNPI-IPPM';
        $video_tag3->tag_name = "Subaru";
        $video_tag3->start = 40;
        $video_tag3->stop = 60;
        $video_tag3->tag_slug_id = 'subaru';
        $video_tag3->complete = 0;

        $input = [$video_tag1, $video_tag2, $video_tag3];

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
                        'start' => 20,
                        'stop' => 40,
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
                        'start' => 40,
                        'stop' => 60,
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
