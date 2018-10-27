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
    public function convert_times()
    {
        $input = '314-357,386-408';

        $output = $this->video_tag_normalizer->convert_times($input);

        $expectedOutput = [
            [
                'start' => 314,
                'stop' => 357
            ],
            [
                'start' => 386,
                'stop' => 408
            ]
        ];

        $this->assertSame($expectedOutput, $output);
    }

    /**
     * @test
     */
    public function normalize()
    {
        $input = [
            [
                "name" => "BMW",
                "times" => "314-357,386-408",
                "slug" => "bmw",
                "complete" => 1
            ]
        ];

        $expectedResult = [
            [
                'name' => 'BMW',
                'times' => [
                    [
                        'start' => 314,
                        'stop' => 357
                    ],
                    [
                        'start' => 386,
                        'stop' => 408
                    ]
                ],
                'slug' => 'bmw',
                'complete' => 1
            ]
        ];

        $normalizer = new VideoTagNormalizer();
        $normalizer->normalize($input);

        $this->assertSame($expectedResult, $input);
    }
}
