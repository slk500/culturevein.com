<?php

use PHPUnit\Framework\TestCase;

class TagsForVideoTest extends TestCase
{
    /**
     * @test
     */
    public function times_to_array()
    {
        $input = '314-357,386-408';

        $output = $this->convert($input);

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

    public function convert(string $string)
    {
        $tmps =  explode(',', $string);

        $output = [];

        foreach ($tmps as $tmp){

                $r = explode('-', $tmp);
                $output []=  [
                    'start' => (int)$r[0],
                    'stop' => (int)$r[1]
                    ];
        }

        return $output;
    }




    /**
     * @test
     */
    public function simple()
    {
        $input = [
            "name" => "BMW",
            "times" => "314-357,386-408",
            "slug" => "bmw",
            "complete" => 1
        ];

        $expectedResult = [
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
            'complete' => false
        ];

        $normalizer = new \Normalizer\TagsForVideo();
        $output = $normalizer->normalize($input);

        $this->assertSame($expectedResult, $output);
    }


    public function normalize()
    {
        $input = [
            0 =>
                [
                    'name' => 'BMW',
                    'start' => 314,
                    'stop' => 357,
                    'slug' => 'bmw',
                ],
            1 =>
                [
                    'name' => 'BMW',
                    'start' => 386,
                    'stop' => 408,
                    'slug' => 'bmw',
                ],
            2 =>
                [
                    'name' => 'Subaru',
                    'start' => 357,
                    'stop' => 371,
                    'slug' => 'subaru',
                ],
        ];


    }
}
